#!/usr/bin/env bash

echo "Installing dependencies..."
docker-compose run --rm frontend.symfony bash -c "yarn install"
docker-compose exec prod.php.symfony composer install --no-interaction --prefer-dist
docker-compose exec prod.php.symfony composer install -d acceptance-tests --no-interaction --prefer-dist
