#!/bin/bash

# Change access rights for the Laravel folders
# in order to make Laravel able to access 
# cache and logs folder.
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/bootstrap/cache
mkdir -p storage/logs/
chgrp -R www-data storage/bootstrap/cache &&\
    chown -R www-data storage/bootstrap/cache 
# Create log file for Laravel and give it write access
# www-data is a standard apache user that must have an
# access to the folder structure
touch storage/logs/laravel.log && chmod 775 storage/logs/laravel.log && chown www-data storage/logs/laravel.log

composer install
php artisan migrate:fresh --seed && echo "Done..."
exec "$@"

