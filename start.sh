#!/usr/bin/env bash

set -e
docker-compose down
echo "Starting services"
docker-compose up -d

echo "Installing dependencies"
docker-compose run --rm composer install

echo "Unit testing..."
docker-compose run --rm php vendor/bin/phpunit
