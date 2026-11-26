#!/usr/bin/env bash
set -e

# Support platforms that inject PORT (Render, Railway, Cloud Run, etc.)
PORT="${PORT:-8080}"
sed -ri "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT}>/g" /etc/apache2/sites-available/*.conf

# Cache Laravel config/routes/views when APP_KEY is provided
if [ -n "${APP_KEY}" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Optionally run migrations on boot when RUN_MIGRATIONS=true
if [ "${RUN_MIGRATIONS}" = "true" ]; then
    php artisan migrate --force
fi

exec apache2-foreground
