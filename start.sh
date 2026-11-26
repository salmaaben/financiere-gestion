#!/usr/bin/env bash
set -euo pipefail

: "${DB_HOST:?Variable DB_HOST manquante}"
: "${DB_DATABASE:?Variable DB_DATABASE manquante}"

php artisan config:cache
php artisan route:cache
php artisan migrate --force
exec apache2-foreground