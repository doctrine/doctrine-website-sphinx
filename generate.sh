#!/bin/bash
cd /var/www/doctrine-website-sphinx
git pull origin master
cd site
tinker -b
