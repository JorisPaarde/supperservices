#!/usr/bin/env bash
# Download a database dump from a URL into database/ and import it.
# Usage:
#   ./scripts/receive-dump.sh https://transfer.sh/xxxxx/export.zip
#   ./scripts/receive-dump.sh https://transfer.sh/xxxxx/export.zip --docker

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

URL="${1:-}"
DOCKER="${2:-}"

if [[ -z "$URL" ]]; then
  echo "Usage: $0 <download-url> [--docker]" >&2
  exit 1
fi

mkdir -p database
NAME="$(basename "${URL%%\?*}")"
[[ "$NAME" == *.* ]] || NAME="staging-export.zip"
DEST="database/$NAME"

echo "Downloading -> $DEST"
curl -fsSL "$URL" -o "$DEST"
ls -lh "$DEST"

if [[ "$DOCKER" == "--docker" ]]; then
  exec "$ROOT_DIR/scripts/import-database-docker.sh" "$DEST"
else
  exec "$ROOT_DIR/scripts/import-database.sh" "$DEST"
fi
