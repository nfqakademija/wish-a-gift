#!/usr/bin/env bash

echo "Starting docker containers..."
docker-compose up -d frontend.symfony prod.php.symfony nginx.symfony selenium.symfony
docker ps -a
