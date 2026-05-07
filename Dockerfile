FROM php:8.2-apache

RUN apt-get update && apt-get install -y git curl unzip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Install PHP dependencies
RUN until composer install --no-dev --optimize-autoloader --no-interaction; do echo "Retrying..."; sleep 5; done

EXPOSE 80
CMD ["apache2-foreground"]