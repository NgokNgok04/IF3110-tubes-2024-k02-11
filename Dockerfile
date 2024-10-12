FROM php:8.3-apache
# add configuration here as needed
# Enable mod_rewrite
RUN a2enmod rewrite


EXPOSE 80