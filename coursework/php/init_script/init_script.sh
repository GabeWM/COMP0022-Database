#!/bin/bash

docker-php-ext-install mysqli
apt-get update && apt-get upgrade -y
echo "hello World"
