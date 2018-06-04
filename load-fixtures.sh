#!/usr/bin/env bash

echo "Loading fixtures..."
docker-compose exec prod.php.symfony bin/console doctrine:fixtures:load --no-interaction
