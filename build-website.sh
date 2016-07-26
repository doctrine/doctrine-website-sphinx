#!/bin/bash

if [ -f "/var/www/doctrine-website-sphinx/regenerate" ];
then 
    rm /var/www/doctrine-website-sphinx/regenerate

    cd /var/www/doctrine-website-sphinx
    git fetch
    git checkout origin/master
    wget -Ocomposer.phar http://getcomposer.org/composer.phar

    php composer.phar install --ignore-platform-reqs

    pushd

    cd vendor/apigen/apigen

    php ../../../composer.phar install --ignore-platform-reqs

    popd

    php bin/build-projects.php

    tinker -b

    mkdir -p site/blog/html/api

    php bin/build-apidocs.php site/blog/html/api
    cp favicon.ico site/blog/html/favicon.ico
    cp site/blog/html/rss.html site/blog/html/rss.xml 
elif
