#!/bin/sh
set -e

# Attendre que MySQL soit pr�t
until mysql -h"db" -u"roadtrip_user" -p"roadtrip_pass" -e "SELECT 1"; do
  echo "Waiting for MySQL..."
  sleep 1
done

echo "MySQL is up - initializing database"

# Ex�cuter le script d'initialisation PHP
php /var/www/html/database/init.php

# D�marrer PHP-FPM
exec php-fpm