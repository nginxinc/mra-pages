#!/bin/sh
pid="/var/run/nginx.pid"    # /   (root directory)

nginx -c /etc/nginx/nginx-php.conf -g "pid $pid;" &
service amplify-agent start
php-fpm -y /etc/php5/fpm/php-fpm.conf -R

sleep 500

while [ -f "$pid" ]
do 
	sleep 500;
done