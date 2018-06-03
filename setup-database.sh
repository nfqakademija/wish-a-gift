#!/usr/bin/env bash

echo "Setting up database..."
docker-compose exec prod.php.symfony bin/console doctrine:database:drop --if-exists --force
docker-compose exec prod.php.symfony bin/console doctrine:database:create
docker-compose exec prod.php.symfony bin/console doctrine:migration:diff
docker-compose exec prod.php.symfony bin/console doctrine:migration:migrate --no-interaction
