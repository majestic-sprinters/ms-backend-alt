# Используем официальный образ PHP с предустановленным Composer
FROM php:8.1-fpm

# Устанавливаем аргументы для переменных окружения (значения будут заданы в docker-compose.yml)
ARG APP_ENV
ARG APP_DEBUG
ARG APP_URL
ARG DB_CONNECTION
ARG DB_HOST
ARG DB_PORT
ARG DB_DATABASE
ARG DB_USERNAME
ARG DB_PASSWORD

# Устанавливаем рабочую директорию в контейнере
WORKDIR /var/www

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libpq-dev

# Очищаем кеш
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем расширения PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Устанавливаем расширение MongoDB
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем исходный код Laravel
COPY . /var/www

# Копируем .env.example в .env
COPY .env.example /var/www/.env

# Устанавливаем зависимости Composer
RUN composer install --optimize-autoloader --no-dev

# Генерируем ключ приложения
RUN php artisan key:generate

# Кэшируем конфигурацию и маршруты
RUN php artisan config:cache
RUN php artisan route:cache

# Оптимизируем загрузку классов
RUN composer dump-autoload --optimize

# Настраиваем права доступа
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage

# Открываем порт 9000
EXPOSE 9000

# Запускаем PHP-FPM
CMD ["php-fpm"]
