#!/bin/sh
set -e

# Attendre que MySQL soit pr�t
until mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1"; do
  echo "MySQL is not ready - sleeping"
  sleep 1
done

echo "MySQL is up - executing initialization"

# Ex�cuter le script d'initialisation PHP
php /var/www/html/database/init.php

# D�marrer PHP-FPM
exec php-fpm