#!/bin/bash
set -e

# Default APP_KEY if not set in cloud dashboard
if [ -z "$APP_KEY" ]; then
    export APP_KEY="base64:Z//La0Qs/OSutnIfm3xqY/nGUCd+EKAr+t7SaWKz/Tc="
fi
export APP_ENV="${APP_ENV:-production}"
export APP_DEBUG="${APP_DEBUG:-true}"
export DB_CONNECTION="${DB_CONNECTION:-sqlite}"

# Pass environment variables to Apache
echo "export APP_KEY='$APP_KEY'" >> /etc/apache2/envvars
echo "export APP_ENV='$APP_ENV'" >> /etc/apache2/envvars
echo "export APP_DEBUG='$APP_DEBUG'" >> /etc/apache2/envvars
echo "export DB_CONNECTION='$DB_CONNECTION'" >> /etc/apache2/envvars

# Set custom port if provided by cloud host (Render, Railway, etc.)
if [ -n "$PORT" ]; then
    sed -i "s/80/$PORT/g" /etc/apache2/ports.conf /etc/apache2/sites-available/*.conf
fi

# Ensure storage directories exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/database

# Ensure SQLite file exists
touch /var/www/html/database/database.sqlite

# Set 777 permissions so Apache (www-data) can read/write everything without restriction
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Clear cache first to reload new env
php artisan config:clear || true
php artisan cache:clear || true
php artisan storage:link || true

# Run database migrations and seed realistic demo data
php artisan migrate --force || true
php artisan db:seed --class=DummyDataSeeder --force || true

# Cache optimized configuration
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache in foreground
exec apache2-foreground
