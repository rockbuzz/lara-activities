FROM php:7.2.25-fpm-alpine

RUN apk add --no-cache $PHPIZE_DEPS bash

RUN pecl install pcov && docker-php-ext-enable pcov

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

ENTRYPOINT ["php-fpm"]