FROM php:8.2-fpm

# Installation des extensions et outils
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Installer Node.js et npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Configuration PHP
COPY docker/php.ini /usr/local/etc/php/php.ini

# Configuration de PHP-FPM
RUN echo "\
[www]\n\
user = www-data\n\
group = www-data\n\
listen = 9000\n\
pm = dynamic\n\
pm.max_children = 5\n\
pm.start_servers = 2\n\
pm.min_spare_servers = 1\n\
pm.max_spare_servers = 3\n\
" > /usr/local/etc/php-fpm.d/www.conf

# Copier le script d'initialisation
COPY docker/init-db.sh /usr/local/bin/init-db.sh
RUN chmod +x /usr/local/bin/init-db.sh

WORKDIR /var/www/html

# Installation de Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Exécuter le script npm pour compiler les fichiers SCSS en CSS
RUN npm run sass

# Commande par d�faut
CMD ["php-fpm"]
