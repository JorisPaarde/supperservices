#!/usr/bin/env bash
# Run this on your Mac to upload a WP Migrate / SQL dump for the cloud agent to import.
# No SSH required — uses a temporary HTTPS link.
#
# Usage:
#   ./scripts/upload-dump.sh
#   ./scripts/upload-dump.sh ~/Downloads/your-export.zip
#
# Then paste the printed link into the Cursor agent chat.

set -euo pipefail

FILE="${1:-}"
if [[ -z "$FILE" ]]; then
  FILE="$(ls -t "$HOME/Downloads"/*.{zip,sql,sql.gz} 2>/dev/null | head -1 || true)"
fi

if [[ -z "$FILE" || ! -f "$FILE" ]]; then
  echo "Usage: $0 [path/to/dump.zip]" >&2
  echo "Or place a .zip / .sql / .sql.gz in ~/Downloads and run without arguments." >&2
  exit 1
fi

NAME="$(basename "$FILE")"
echo "Uploading: $FILE ($(du -h "$FILE" | cut -f1))"
echo ""

URL="$(curl --progress-bar --upload-file "$FILE" "https://transfer.sh/$NAME")"
echo ""
echo "Upload complete. Send this to the Cursor agent:"
echo ""
echo "  Import my database: $URL"
echo ""
echo "The agent can run:"
echo "  curl -fsSL \"$URL\" -o database/$NAME && ./scripts/import-database.sh database/$NAME"
