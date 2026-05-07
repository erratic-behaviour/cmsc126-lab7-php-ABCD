FROM php:8.2-apache

# dependencies for mysqli and composer
RUN apt-get update && apt-get install -y git curl && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

#gets composer 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html/

WORKDIR /var/www/html

RUN composer install

EXPOSE 80
CMD ["apache2-foreground"]