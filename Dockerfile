FROM php:8.2-apache
RUN composer install --no-dev
COPY . /var/www/html/
EXPOSE 80