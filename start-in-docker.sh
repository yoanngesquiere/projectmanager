#!/bin/bash

# Script created to launch the project manager in docker using fig
# A simple "fig up" is not enough because we need to setup the database and other things
# All actions that must be run in the container can be added in the docker_setup script
# Requires docker >= 1.3

docker-compose build
docker-compose up -d
docker exec projectmanager_web_1 /var/www/docker_setup.sh

echo "project IP :"
docker inspect projectmanager_web_1 | awk -F '"' '/IPAdd/ {print $4}'
