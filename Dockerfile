FROM php:8.4-fpm

# Установка системных зависимостей (включая libicu для intl)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    gettext \
    zip \
    unzip \
    nginx \
    supervisor \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Разрешаем Composer работать как root (нужно для Railway)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Рабочая директория
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Создание директорий и установка прав
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

# Кэширование конфигов
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Копирование конфигов Nginx и Supervisor
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisor.conf /etc/supervisor/conf.d/supervisord.conf

# Копирование скрипта запуска
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Открываем порт 80
EXPOSE 80

# Команда запуска
CMD ["/start.sh"]