#!/bin/sh
set -e

# Attendre que MySQL soit prêt
until mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" -e "SELECT 1"; do
  echo "MySQL is not ready - sleeping"
  sleep 1
done

echo "MySQL is up - executing initialization"

# Exécuter le script d'initialisation PHP
php /var/www/html/database/init.php

# Démarrer PHP-FPM
exec php-fpm