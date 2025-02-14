#!/bin/sh
# wait-for-db.sh

set -e

until php /var/www/html/database/init.php; do
  echo "Database initialization pending..."
  sleep 2
done

echo "Database initialized, starting PHP-FPM..."
php-fpm