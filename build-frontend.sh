#!/usr/bin/env bash

echo "Building frontend assets..."
docker-compose run --rm frontend.symfony bash -c "yarn run encore production"
