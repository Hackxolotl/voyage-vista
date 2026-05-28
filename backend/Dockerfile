FROM php:8.2-apache

# Extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Active rewrite (utile API)
RUN a2enmod rewrite

# IMPORTANT : ne touche PAS aux MPM

# copie du backend
COPY . /var/www/html/

# permissions propres
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
