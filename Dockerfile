# Use the official PHP image as base
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libssl-dev

# Install MongoDB extension
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json and composer.lock to install dependencies
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .

# Generate autoload files and optimize
RUN composer dump-autoload --optimize

# Expose port 9000 to be used by Laravel application
EXPOSE 9000

# Start Laravel's built-in server
CMD php artisan serve --host=0.0.0.0 --port=9000
