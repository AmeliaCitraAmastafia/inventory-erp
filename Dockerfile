FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --optimize-autoloader
COPY . .
RUN mkdir -p bootstrap/cache && composer dump-autoload --optimize --no-dev

FROM php:8.4-cli-alpine
WORKDIR /var/www/html

RUN apk add --no-cache postgresql-dev bash \
    && docker-php-ext-install pdo pdo_pgsql

COPY --from=vendor /app /var/www/html

RUN mkdir -p storage/app/private storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
