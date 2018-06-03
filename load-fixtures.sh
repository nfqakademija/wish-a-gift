#!/usr/bin/env bash

echo "Loading fixtures..."
docker-compose exec prod.php.symfony bin/console doc:fixtures:load --no-interaction
