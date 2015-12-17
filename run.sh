#!/usr/bin/env bash

ENV="development"

if [ "$1" == "-p" ]; then
    ENV="production"
fi

echo $ENV

docker-compose -f $ENV.yml build

./user.sh $1

DIR="www/html/"$ENV

if [ "$(ls -A $DIR)" ]; then
     echo "Take action $DIR is not Empty"
#     sudo docker run -ti -v $(pwd)"/"$DIR:/app composer/composer update
else
    echo "$DIR is Empty"
    echo $(pwd)"/"$DIR
    git clone git@178.62.82.235:root/automated-services.git $DIR
    sudo docker run -ti -v $(pwd)"/"$DIR:/app composer/composer install
fi

./user.sh $1

docker-compose -f $ENV.yml up -d
