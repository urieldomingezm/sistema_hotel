
FROM php:8.2-apache


WORKDIR /var/www/html


COPY . .

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip gd


RUN a2enmod rewrite


EXPOSE 80


CMD ["apache2-foreground"]