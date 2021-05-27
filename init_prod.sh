#!/bin/bash
set -e

cd /var/www

chmod -R 777 storage/ bootstrap/cache

mkdir -p public/images
chmod -R 777 public/images
mkdir -p public/temp
chmod -R 777 public/temp

php artisan down

php artisan admin:install
php artisan storage:link
php artisan migrate --force
php artisan db:seed
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan package:discover

service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl restart all
php artisan queue:restart

php artisan up
