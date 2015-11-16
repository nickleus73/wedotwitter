#!/usr/bin/env bash

docker-compose -f $1.yml build

./user.sh

DIR="www/html/"$1

if [ "$(ls -A $DIR)" ]; then
     echo "Take action $DIR is not Empty"
#     sudo docker run -ti -v $(pwd)"/"$DIR:/app composer/composer update
else
    echo "$DIR is Empty"
    echo $(pwd)"/"$DIR
    git clone git@178.62.82.235:root/automated-services.git $DIR
    sudo docker run -ti -v $(pwd)"/"$DIR:/app composer/composer install
fi

./user.sh

docker-compose -f $1.yml up -d
