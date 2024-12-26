FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
     git unzip nano libpq-dev libjpeg-dev libpng-dev libfreetype6-dev libzip-dev zlib1g-dev pkg-config libicu-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip bcmath intl gd

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update

WORKDIR var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader
CMD ["php-fpm"]
