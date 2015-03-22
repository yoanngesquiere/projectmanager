#!/bin/bash

# Script created to launch the project manager in docker using docker compose (with 2 containers)
# or inside a single image
# A simple "docker-compose up" is not enough because we need to setup the database and other things
# All actions that must be run in the container can be added in the docker_setup script
# Requires docker >= 1.3

if [ "$1" == "baseimage" ]; then
    # Stop the current image if it is running
    docker stop $(docker ps | grep pm | awk '{ print $(NF) }')

    # Use baseimage
    cp docker/baseimage/Dockerfile .

    if [ "$2" != "nobuild" ]; then
        docker build -t pm .
    fi

    docker run -d pm
    docker inspect $(docker ps | grep pm | awk '{ print $(NF) }') | grep IPAddress
    rm Dockerfile
elif [ "$1" == "compose" ]; then
    # Use docker-compose
    cd docker/docker-compose

    if [ "$2" != "nobuild" ]; then
        docker-compose build
    fi

    docker-compose up -d
    docker exec dockercompose_web_1 /var/www/docker/docker-compose/docker_setup.sh

    echo "project IP :"
    docker inspect dockercompose_web_1 | awk -F '"' '/IPAdd/ {print $4}'
else
    echo "Usage: ./start-in-docker.sh <image> [nobuild]"
    echo ""
    echo "image (mandatory):"
    echo " - baseimage: for a single image with no link with your filesystem. You must rebuild after a source update."
    echo "              This choice is great to try the application."
    echo " - compose:   for two images and a link to your file system. You don't have to rebuild after an update"
    echo "              This choice is great if you want to update the application."
    echo ""
    echo "Options:"
    echo " - nobuild:   Specifies that you don't want to rebuild the docker image(s)."
fi
