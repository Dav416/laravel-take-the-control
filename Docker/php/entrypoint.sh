#!/bin/bash
set -e

echo "[entrypoint] Waiting for MySQL at ${DB_HOST}:${DB_PORT}..."
until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    sleep 2
done
echo "[entrypoint] MySQL is ready."

# Fix storage permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Generate app key if missing
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "[entrypoint] Generating APP_KEY..."
    php artisan key:generate --force
fi

# Run pending migrations
echo "[entrypoint] Running migrations..."
php artisan migrate --force

echo "[entrypoint] Starting php-fpm..."
exec "$@"
