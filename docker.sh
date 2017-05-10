#!/bin/sh

apt-get update
&& apt-get install -y libmcrypt-dev mysql-client libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng12-dev
&& echo '#######################################'
&& docker-php-ext-install -j$(nproc) iconv mcrypt pdo_mysql
&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
&& docker-php-ext-install -j$(nproc) gd
