#!/bin/bash

# Устанавливаем переменные окружения для Laravel
export APP_ENV=production
export APP_DEBUG=false

# Миграции БД
echo "Running migrations..."
php artisan migrate --force

# Кэширование
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск supervisor (который запустит nginx и php-fpm)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf