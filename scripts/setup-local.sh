#!/usr/bin/env bash
# Local setup on your Mac (Docker Desktop required).
#
# Usage:
#   ./scripts/setup-local.sh
#   ./scripts/setup-local.sh ~/Downloads/staging-export.zip
#
# Site: http://localhost:8080

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

if ! command -v docker &>/dev/null; then
  echo "Install Docker Desktop: https://www.docker.com/products/docker-desktop/" >&2
  exit 1
fi

if [[ ! -f .env ]]; then
  cp .env.example .env
  # Docker: DB runs in the db service; app container reads .env from the mount.
  sed -i.bak "s/DB_NAME='database_name'/DB_NAME='supper_saves'/" .env
  sed -i.bak "s/DB_USER='database_user'/DB_USER='supper'/" .env
  sed -i.bak "s/DB_PASSWORD='database_password'/DB_PASSWORD='supper'/" .env
  sed -i.bak "s|WP_HOME='http://localhost'|WP_HOME='http://localhost:8080'|" .env
  if ! grep -q "^DB_HOST=" .env; then
    echo "DB_HOST='db'" >> .env
  else
    sed -i.bak "s/# DB_HOST='localhost'/DB_HOST='db'/" .env
  fi
  rm -f .env.bak
  echo ""
  echo "Created .env — add WordPress salts from https://roots.io/salts.html"
  echo ""
fi

echo "==> Composer (project)"
composer install --no-interaction

echo "==> Composer (theme)"
composer install --no-interaction --working-dir=web/app/themes/supper-saves

echo "==> Node (theme assets)"
if command -v nvm &>/dev/null || [[ -s "$HOME/.nvm/nvm.sh" ]]; then
  # shellcheck disable=SC1091
  . "$HOME/.nvm/nvm.sh" 2>/dev/null || true
  nvm install 14 2>/dev/null || true
  nvm use 14 2>/dev/null || true
fi
(
  cd web/app/themes/supper-saves
  npm ci --no-audit
  npm run dev
)

echo "==> Docker"
docker compose up -d

DUMP="${1:-}"
if [[ -n "$DUMP" ]]; then
  mkdir -p database
  cp "$DUMP" "database/$(basename "$DUMP")"
  ./scripts/import-database-docker.sh "database/$(basename "$DUMP")"
else
  echo ""
  echo "No dump imported yet. To import your WP Migrate zip:"
  echo "  ./scripts/setup-local.sh ~/Downloads/your-export.zip"
  echo "  # or after setup:"
  echo "  ./scripts/import-database-docker.sh ~/Downloads/your-export.zip"
fi

echo ""
echo "Site:  http://localhost:8080"
echo "Admin: http://localhost:8080/wp/wp-admin/"
