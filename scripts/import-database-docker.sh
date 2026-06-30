#!/usr/bin/env bash
# Import dump when using docker compose (DB in container "db", wp-cli in "wpcli").
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

DB_NAME="supper_saves"
LOCAL_URL="http://localhost:8080"
DUMP="${1:-}"

if [[ -z "$DUMP" ]]; then
  DUMP="$(find database -maxdepth 1 -type f \( -iname '*.sql' -o -iname '*.sql.gz' -o -iname '*.zip' \) -printf '%T@ %p\n' 2>/dev/null | sort -nr | head -1 | cut -d' ' -f2-)"
fi
[[ -n "$DUMP" && -f "$DUMP" ]] || { echo "No dump file found." >&2; exit 1; }

if [[ -f .env ]]; then
  val="$(grep -E '^WP_HOME=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && LOCAL_URL="$val"
fi

echo "Using dump: $DUMP"
docker compose up -d db
echo "Waiting for database..."
for i in $(seq 1 30); do
  docker compose exec -T db mariadb-admin ping -h localhost --silent 2>/dev/null && break
  sleep 2
done

extract_sql() {
  case "$1" in
    *.sql) cat "$1" ;;
    *.sql.gz|*.gz) gunzip -c "$1" ;;
    *.zip)
      sql="$(unzip -Z1 "$1" | grep -E '\.sql$' | head -1)"
      unzip -p "$1" "$sql"
      ;;
    *) echo "Unsupported format: $1" >&2; exit 1 ;;
  esac
}

docker compose exec -T db mariadb -uroot -proot -e "DROP DATABASE IF EXISTS \`$DB_NAME\`; CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; GRANT ALL ON \`$DB_NAME\`.* TO 'supper'@'%'; FLUSH PRIVILEGES;"

echo "Importing..."
extract_sql "$DUMP" | docker compose exec -T db mariadb -usupper -psupper "$DB_NAME"

docker compose run --rm wpcli --path=web/wp option get siteurl 2>/dev/null || true
OLD_SITEURL="$(docker compose run --rm wpcli --path=web/wp option get siteurl 2>/dev/null | tail -1 || true)"
OLD_HOME="$(docker compose run --rm wpcli --path=web/wp option get home 2>/dev/null | tail -1 || true)"

replace() {
  local from="$1"
  [[ -n "$from" && "$from" != "$LOCAL_URL" ]] || return 0
  echo "  $from -> $LOCAL_URL"
  docker compose run --rm wpcli --path=web/wp search-replace "$from" "$LOCAL_URL" --all-tables --precise --recurse-objects --skip-columns=guid
}

echo "Rewriting URLs..."
replace "$OLD_SITEURL"
replace "$OLD_HOME"
[[ "$OLD_SITEURL" == http://* ]] && replace "${OLD_SITEURL/http:/https:}"
[[ "$OLD_HOME" == http://* ]] && replace "${OLD_HOME/http:/https:}"

docker compose run --rm wpcli --path=web/wp rewrite flush
docker compose run --rm wpcli --path=web/wp theme activate supper-saves/resources 2>/dev/null || true
docker compose run --rm wpcli --path=web/wp plugin is-active advanced-custom-fields 2>/dev/null || \
  docker compose run --rm wpcli --path=web/wp plugin install advanced-custom-fields --activate

docker compose up -d app
echo ""
echo "Done. Open $LOCAL_URL"
