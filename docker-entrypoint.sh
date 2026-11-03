#!/bin/bash
set -e

# Set custom port if provided by cloud host (Render, Railway, etc.)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Run storage link and cache clearing
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations
php artisan migrate --force || true

# Start Apache in foreground
exec apache2-foreground
