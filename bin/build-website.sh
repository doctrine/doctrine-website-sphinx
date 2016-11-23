#!/bin/bash

if [ -f "/var/www/doctrine-website-sphinx/notify/regenerate" ];
then
    rm /var/www/doctrine-website-sphinx/notify/regenerate

    cd /var/www/doctrine-website-sphinx
    git checkout -- .
    git checkout master
    git fetch
    git merge origin/master
    wget -Ocomposer.phar http://getcomposer.org/composer.phar

    php composer.phar install --ignore-platform-reqs

    cd vendor/apigen/apigen

    php ../../../composer.phar install --ignore-platform-reqs

    cd /var/www/doctrine-website-sphinx
    php bin/build-projects.php

    cd /var/www/doctrine-website-sphinx/site
    tinker -b

    cd /var/www/doctrine-website-sphinx
    mkdir -p public/api

    rsync -avz /var/www/doctrine-website-sphinx/site/blog/html/ /var/www/doctrine-website-sphinx/public

    cp favicon.ico public/favicon.ico
    cp public/rss.html public/rss.xml
fi
