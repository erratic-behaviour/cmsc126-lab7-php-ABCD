FROM php:8.2-apache

RUN apt-get update && apt-get install -y git curl && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

# Create uploads folder with write permissions for Apache
RUN mkdir -p /var/www/html/uploads && chmod 755 /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]