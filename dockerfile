FROM php:8.2-fpm

# Устанавливаем зависимости и расширения
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql mbstring xml \
    && docker-php-ext-enable pdo_mysql

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
