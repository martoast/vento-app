#!/usr/bin/env bash
# Netlify CI build: prep Laravel, then run the static export into ./dist
# (locally the export goes to ../dist; CI overrides OUT so the publish
# dir lives inside the repo).
set -euo pipefail
composer install --no-interaction --prefer-dist --quiet
[ -f .env ] || cp .env.example .env
php artisan key:generate --force --quiet
OUT=dist ./build-static.sh
