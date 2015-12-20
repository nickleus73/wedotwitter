#!/usr/bin/env bash

ENV="development"
USER=""
PASSWORD=""

user() {
    USER=$(whoami)

    sudo chown -R $USER:$USER www
    sudo chmod -R 777 www/html/$1/storage
}

build() {
    if [ "$(ls -A $DIR)" ]; then
     echo "Take action $DIR is not Empty"
     sudo docker run -ti -v $(pwd)"/"$1:/app composer/composer update
    else
        echo "$DIR is Empty"
        echo $(pwd)"/"$1
        git clone http://$2:$3@178.62.82.235/root/automated-services.git $1
        sudo docker run -ti -v $(pwd)"/"$1:/app composer/composer install
    fi
}

if [ "$2" == "--p" ]; then
    ENV="production"
fi

if [ -n "$3" ]; then
    USER=$3
fi

if [ -n "$4" ]; then
    PASSWORD=$4
fi

DIR="www/html/"$ENV

# Run server in bash
if [ "$1" == "--e" ]; then
    docker exec -it server bash
fi

# Stop server
if [ "$1" == "--s" ]; then
    docker-compose -f $ENV.yml stop
fi

# Reset user permissions
if [ "$1" == "--u" ]; then
    user $ENV
fi

# Run server with phpunit
if [ "$1" == "--unit" ]; then
    docker exec -it server php artisan migrate:reset
    docker exec -it server vendor/bin/phpunit
fi

# Build and run server
if [ "$1" == "--r" ]; then
    docker-compose -f $ENV.yml build

    build $DIR $USER $PASSWORD

#    user $ENV

    docker-compose -f $ENV.yml up -d
fi

# Stop deploy server
if [ "$1" == "--d" ]; then
    build $DIR

    user $ENV
fi