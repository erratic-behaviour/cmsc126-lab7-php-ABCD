FROM php:8.2-apache

RUN apt-get update && apt-get install -y git curl && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80
CMD ["apache2-foreground"]