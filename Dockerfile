FROM php:8.4-fpm

# Установка системных зависимостей
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
    procps \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Рабочая директория
WORKDIR /var/www/html

# Копирование файлов проекта
COPY . .

# Установка зависимостей Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Создание ВСЕХ необходимых директорий
RUN mkdir -p \
    storage/logs \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    bootstrap/cache

# Установка прав (777 для простоты, в продакшене лучше 775)
RUN chmod -R 777 storage bootstrap/cache

# Создание символической ссылки для storage
RUN php artisan storage:link || true

# Кэширование конфигов
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Копирование конфигов
COPY nginx.conf /etc/nginx/sites-enabled/default
COPY supervisor.conf /etc/supervisor/conf.d/supervisord.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]