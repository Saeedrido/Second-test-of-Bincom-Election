#!/bin/bash
set -e

# Map Railway MySQL env vars to Laravel DB_* vars if not already set
export DB_CONNECTION="${DB_CONNECTION:-mysql}"
export DB_HOST="${DB_HOST:-${MYSQLHOST:-127.0.0.1}}"
export DB_PORT="${DB_PORT:-${MYSQLPORT:-3306}}"
export DB_DATABASE="${DB_DATABASE:-${MYSQLDATABASE:-bincomphptest}}"
export DB_USERNAME="${DB_USERNAME:-${MYSQLUSER:-root}}"
export DB_PASSWORD="${DB_PASSWORD:-${MYSQLPASSWORD:-}}"

echo "Starting INEC Election Dashboard..."
echo "Database: $DB_CONNECTION://$DB_USERNAME@$DB_HOST:$DB_PORT/$DB_DATABASE"

# Cache config at runtime (needs env vars available)
php artisan config:cache 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Seed database only if polling_unit table is empty
SEED_CHECK=$(php -r "
try {
    \$pdo = new PDO('mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD');
    \$count = \$pdo->query('SELECT COUNT(*) FROM polling_unit')->fetchColumn();
    echo \$count > 0 ? 'skip' : 'seed';
} catch (Exception \$e) {
    echo 'seed';
}
" 2>/dev/null || echo "seed")

if [ "$SEED_CHECK" = "seed" ]; then
    echo "Database empty — seeding..."
    php artisan db:seed --force
else
    echo "Database already populated — skipping seed."
fi

# Start the server
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
