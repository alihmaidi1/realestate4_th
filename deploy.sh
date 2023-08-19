#!/bin/bash
set -e

echo "Deployment started ..."

# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true
echo "downed successfully"

# Pull the latest version of the app
git pull origin master
echo "pulling successfully started ..."

# Install composer dependencies
/usr/bin/php7.4 /usr/local/bin/composer install --no-dev

echo "compoesr install"


# Recreate cache
php artisan optimize

echo "clear cache started ..."


php artisan migrate
php artisan migrate:fresh

echo "database fresh"



php artisan db:seed

echo "databaase seeding"


php artisan storage:link

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
