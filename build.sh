#!/usr/bin/env bash

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache
