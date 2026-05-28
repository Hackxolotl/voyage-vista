FROM php:8.2-apache

# Installe PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Désactive les MPM conflictuels et force prefork
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork

# Active rewrite (utile pour API)
RUN a2enmod rewrite

COPY . /var/www/html/

EXPOSE 80
