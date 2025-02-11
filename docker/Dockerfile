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
    && docker-php-ext-configure gd \
    && docker-php-ext-install pdo_mysql gd zip

# Configuration PHP
COPY php.ini /usr/local/etc/php/php.ini

# Définition du dossier de travail
WORKDIR /var/www/html
