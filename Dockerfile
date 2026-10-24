
FROM php:8.2-apache


WORKDIR /var/www/html


COPY . .

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip gd


COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite


EXPOSE 80


CMD ["apache2-foreground"]