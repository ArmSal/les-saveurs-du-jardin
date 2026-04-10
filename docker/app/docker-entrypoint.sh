#!/bin/sh
set -e

# Wait for MySQL to be ready
echo "Waiting for database to be ready..."
until nc -z db 3306; do
  sleep 1
done
echo "Database is ready!"

# Ensure var directory exists and is writable
mkdir -p var
chmod -R 777 var

# Create database and update schema from entities
echo "Creating database if not exists..."
php bin/console doctrine:database:create --if-not-exists --no-interaction

echo "Updating schema from Symfony entities..."
php bin/console doctrine:schema:update --force --no-interaction

echo "Creating default Directeur user..."
php bin/console app:create-admin --no-interaction

# Execute original command (php-fpm)
exec "$@"
