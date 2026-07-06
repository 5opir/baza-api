#!/bin/bash

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
LOG_LEVEL=error
EOF

# ВАЖНО: Очищаем кеш конфига
echo "Clearing config cache..."
php artisan config:clear
php artisan cache:clear

# Проверяем, что .env создан правильно
echo "=== .env DB settings ==="
cat .env | grep -E "^DB_"
echo "========================"

# Проверяем подключение к БД
echo "Testing MySQL connection..."
php artisan tinker --execute="
try {
    \$pdo = DB::connection()->getPdo();
    echo 'MySQL connection: OK\n';
    echo 'Database: ' . \$pdo->query('SELECT DATABASE()')->fetchColumn() . '\n';
} catch (Exception \$e) {
    echo 'MySQL connection: FAILED - ' . \$e->getMessage() . '\n';
    exit(1);
}
" || exit 1

# Выполняем миграции
echo "Running migrations..."
php artisan migrate --force --no-interaction

# Заполняем тестовые данные (только если таблица films пустая)
echo "Checking if seeding is needed..."
php artisan tinker --execute="
if (\App\Models\Film::count() === 0) {
    echo 'Seeding database...\n';
    Artisan::call('db:seed', ['--class' => 'BazaSeeder', '--force' => true]);
    echo 'Seeding completed.\n';
} else {
    echo 'Database already has data, skipping seed.\n';
}
"

# Кэширование
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Запуск supervisor
echo "Starting supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf