#!/usr/bin/env bash

cd www/html/
sudo docker run -ti -v $(pwd):/app composer/composer create-project laravel/laravel . --prefer-dist