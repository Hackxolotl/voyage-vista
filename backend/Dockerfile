FROM php:8.2-apache

# Extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# IMPORTANT : désactive TOUT MPM avant de forcer prefork
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true

# force clean reload Apache modules
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load || true
RUN a2enmod mpm_prefork

# modules utiles API
RUN a2enmod rewrite

# copie projet
COPY . /var/www/html/

EXPOSE 80
