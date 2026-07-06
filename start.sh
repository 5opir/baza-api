#!/bin/bash

# Диагностика прав
echo "=== CHECKING PERMISSIONS ==="
ls -la storage/
ls -la bootstrap/cache/
echo "============================"

# Устанавливаем переменные окружения
export APP_ENV=production
export APP_DEBUG=false

# Создаём .env файл
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

LOG_CHANNEL=stderr
LOG_LEVEL=debug
EOF

# Миграции
echo "Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "MIGRATION FAILED!"

# Проверяем, может ли Laravel писать
echo "Testing write permissions..."
php artisan config:cache && echo "Config cache OK" || echo "Config cache FAILED"
php artisan route:cache && echo "Route cache OK" || echo "Route cache FAILED"
php artisan view:cache && echo "View cache OK" || echo "View cache FAILED"

# Запуск supervisor
echo "Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf