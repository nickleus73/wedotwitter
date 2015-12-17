#!/usr/bin/env bash

ENV="development"

if [ "$1" == "-p" ]; then
    ENV="production"
fi

USER=$(whoami)

sudo chown -R $USER:$USER www
sudo chmod -R 777 www/html/$ENV/storage