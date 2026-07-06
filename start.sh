#!/bin/bash

# Устанавливаем переменные окружения
export APP_ENV=production
export APP_DEBUG=false

# Создаём .env файл из переменных окружения Railway
cat > .env << EOF
APP_NAME="Olmo Studio"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=${RAILWAY_PUBLIC_DOMAIN}

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT:-3306}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF

# Подставляем порт из переменной PORT в nginx.conf
export PORT=${PORT:-80}
envsubst '${PORT}' < /etc/nginx/sites-enabled/default > /etc/nginx/sites-enabled/default.tmp
mv /etc/nginx/sites-enabled/default.tmp /etc/nginx/sites-enabled/default

# Миграции БД
echo "Running migrations..."
php artisan migrate --force

# Кэширование
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf