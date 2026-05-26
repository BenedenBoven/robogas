#!/bin/bash

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Load environment variables from .env file
if [ -f "$SCRIPT_DIR/.env" ]; then
    source "$SCRIPT_DIR/.env"
fi

LOCAL_UPLOADS="$SCRIPT_DIR/public/uploads"
REMOTE_UPLOADS="ssh://benedenboven@93.119.13.234//var/www/${APP_NAME}/public/uploads"

unison "$LOCAL_UPLOADS" "$REMOTE_UPLOADS" \
  -auto \
  -batch \
  -prefer newer \
  -repeat 5 \
  -ui text