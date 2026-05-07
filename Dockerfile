FROM php:8.2-apache

#php 
RUN apt-get update && apt-get install -y git curl && rm -rf /var/lib/apt/lists/*

#sql
RUN docker-php-ext-install mysqli

# our php files
COPY . /var/www/html/

# folder for uploads and gives permission to apache to write to the folder
RUN mkdir -p /var/www/html/uploads && chmod 755 /var/www/html/uploads
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
#tells command line of render to use apache and start sit
CMD ["apache2-foreground"]