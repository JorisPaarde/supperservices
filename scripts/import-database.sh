#!/usr/bin/env bash
# Import a WordPress/MySQL dump into the local MariaDB used by this Bedrock site.
# Usage:
#   ./scripts/import-database.sh [path/to/dump.sql|dump.sql.gz|dump.zip]
# If no path is given, uses the newest file in ./database/

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

DB_NAME="${DB_NAME:-supper_saves}"
DB_USER="${DB_USER:-supper}"
DB_PASSWORD="${DB_PASSWORD:-supper}"
DB_HOST="${DB_HOST:-127.0.0.1}"
LOCAL_URL="${LOCAL_URL:-http://localhost:8080}"

load_env() {
  if [[ ! -f .env ]]; then
    return
  fi
  local val
  val="$(grep -E '^DB_NAME=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && DB_NAME="$val"
  val="$(grep -E '^DB_USER=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && DB_USER="$val"
  val="$(grep -E '^DB_PASSWORD=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && DB_PASSWORD="$val"
  val="$(grep -E '^DB_HOST=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && DB_HOST="$val"
  val="$(grep -E '^WP_HOME=' .env | head -1 | cut -d= -f2- | tr -d "'\"")" && [[ -n "$val" ]] && LOCAL_URL="$val"
}

find_dump() {
  local dump="${1:-}"
  if [[ -n "$dump" ]]; then
    if [[ ! -f "$dump" ]]; then
      echo "Error: dump file not found: $dump" >&2
      exit 1
    fi
    echo "$dump"
    return
  fi

  dump="$(find database "$HOME/Downloads" -maxdepth 1 -type f \( -iname '*.sql' -o -iname '*.sql.gz' -o -iname '*.zip' -o -iname '*.tar.gz' \) -printf '%T@ %p\n' 2>/dev/null | sort -nr | head -1 | cut -d' ' -f2-)"
  if [[ -z "$dump" ]]; then
    echo "Error: no dump found in database/ or ~/Downloads. Place your .sql or .sql.gz file there and retry." >&2
    exit 1
  fi
  echo "$dump"
}

extract_sql_stream() {
  local dump="$1"
  case "$dump" in
    *.sql) cat "$dump" ;;
    *.sql.gz|*.gz) gunzip -c "$dump" ;;
    *.zip)
      local sql
      sql="$(unzip -Z1 "$dump" | grep -E '\.sql$' | head -1)"
      if [[ -z "$sql" ]]; then
        echo "Error: no .sql file inside zip: $dump" >&2
        exit 1
      fi
      unzip -p "$dump" "$sql"
      ;;
    *.tar.gz|*.tgz)
      tar -xOzf "$dump" --wildcards '*.sql' 2>/dev/null | head -c 1 >/dev/null || true
      tar -xOzf "$dump" --wildcards '*.sql'
      ;;
    *)
      echo "Error: unsupported dump format: $dump" >&2
      exit 1
      ;;
  esac
}

load_env

DUMP_FILE="$(find_dump "${1:-}")"
echo "Using dump: $DUMP_FILE"

echo "Starting MariaDB (if needed)..."
sudo service mariadb start >/dev/null 2>&1 || true

echo "Recreating database '$DB_NAME'..."
sudo mysql -e "DROP DATABASE IF EXISTS \`$DB_NAME\`; CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASSWORD'; GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost'; FLUSH PRIVILEGES;"

echo "Importing (this may take a while)..."
extract_sql_stream "$DUMP_FILE" | sudo mysql "$DB_NAME"

echo "Detecting site URLs from imported database..."
OLD_SITEURL="$(wp option get siteurl --allow-root 2>/dev/null || true)"
OLD_HOME="$(wp option get home --allow-root 2>/dev/null || true)"

replace_url() {
  local from="$1"
  if [[ -n "$from" && "$from" != "$LOCAL_URL" ]]; then
    echo "  $from -> $LOCAL_URL"
    wp search-replace "$from" "$LOCAL_URL" --all-tables --precise --recurse-objects --skip-columns=guid --allow-root >/dev/null
  fi
}

if [[ -n "$OLD_SITEURL" || -n "$OLD_HOME" ]]; then
  echo "Rewriting URLs for local dev..."
  replace_url "$OLD_SITEURL"
  replace_url "$OLD_HOME"
  # Also handle https variant if dump used http
  if [[ "$OLD_SITEURL" == http://* ]]; then
    replace_url "${OLD_SITEURL/http:/https:}"
  fi
  if [[ "$OLD_HOME" == http://* ]]; then
    replace_url "${OLD_HOME/http:/https:}"
  fi
else
  echo "Warning: could not read siteurl/home; skipping search-replace."
fi

wp rewrite flush --hard --allow-root >/dev/null 2>&1 || wp rewrite flush --allow-root >/dev/null
wp cache flush --allow-root >/dev/null 2>&1 || true

# Theme + runtime deps from prior dev setup
wp theme activate supper-saves/resources --allow-root >/dev/null 2>&1 || true
wp plugin is-active advanced-custom-fields --allow-root >/dev/null 2>&1 || wp plugin install advanced-custom-fields --activate --allow-root >/dev/null 2>&1 || true

echo ""
echo "Import complete."
echo "  Database : $DB_NAME"
echo "  Site URL : $(wp option get home --allow-root 2>/dev/null || echo "$LOCAL_URL")"
echo "  Dev URL  : $LOCAL_URL"
echo "  Admin    : ${LOCAL_URL}/wp/wp-admin/"
