#!/bin/bash

export APP_ENV=production
export APP_DEBUG=false

# Создаём .env
cat > .env << EOF
APP_NAME="Olmo Studio"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=https://${RAILWAY_PUBLIC_DOMAIN:-localhost}

DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST:-mysql.railway.internal}
DB_PORT=${MYSQLPORT:-3306}
DB_DATABASE=${MYSQLDATABASE:-railway}
DB_USERNAME=${MYSQLUSER:-root}
DB_PASSWORD=${MYSQLPASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
EOF

# Подставляем PORT в nginx.conf
export PORT=${PORT:-8080}
echo "Configuring nginx to listen on PORT=$PORT"
envsubst '${PORT}' < /etc/nginx/sites-enabled/default > /etc/nginx/sites-enabled/default.tmp
mv /etc/nginx/sites-enabled/default.tmp /etc/nginx/sites-enabled/default

# Проверяем конфиг
nginx -t || exit 1

# Миграции
php artisan migrate --force --no-interaction 2>&1 || echo "MIGRATION FAILED!"

# Кэширование
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf