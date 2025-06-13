#!/bin/bash
set -e

cd /var/www/html/app || exit 1

echo "Running composer install..."
composer install

echo "Running doctrine migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Loading doctrine fixtures..."
php bin/console doctrine:fixtures:load --no-interaction

echo "Building assets with yarn..."
yarn install
yarn encore production

echo "✅ App setup complete."
