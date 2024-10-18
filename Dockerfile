# Dockerfile
FROM php:8.3-apache

# Install PostgreSQL PDO driver
RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql pgsql
COPY php/php.ini /usr/local/etc/php/php.ini
# Copy the application files
COPY ./php/src /var/www/html

# Enable mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

EXPOSE 80