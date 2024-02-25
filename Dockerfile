FROM php:8.1-fpm
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader
COPY . .
RUN composer dump-autoload --optimize
EXPOSE 9000

CMD php artisan serve --host=0.0.0.0 --port=9000
