#!/usr/bin/env bash

echo "Starting docker containers..."
docker-compose up -d frontend.symfony mysql.symfony prod.php.symfony nginx.symfony selenium.symfony
docker ps -a
