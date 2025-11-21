#!/bin/bash

echo "Waiting for MySQL to be ready..."
for i in {1..30}; do
    if php artisan db:show > /dev/null 2>&1; then
        echo "MySQL is ready!"
        break
    fi
    echo "Waiting... ($i/30)"
    sleep 2
done

echo "Running migrations..."
php artisan migrate --force

echo "Setting permissions..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Starting application..."
echo "Access at: http://localhost"

su -s /bin/bash www-data -c "php artisan serve --host=0.0.0.0 --port=80"
