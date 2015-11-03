#!/usr/bin/env bash

TEST=$(hostname | tr '[:upper:]' '[:lower:]')

sudo chown -R $TEST:$TEST www
sudo chmod -R 777 www/html/storage