#!/bin/sh
pid="/var/run/nginx.pid"    # /   (root directory)

nginx -c /etc/nginx/nginx-php.conf -g "pid $pid; worker_processes 2;" &

/etc/init.d/php5-fpm start

#/usr/bin/php -t /inginious-pages /inginious-pages/app/console server:run

chgrp nginx /var/run/php5-fpm.sock

sleep 500

while [ -f "$pid" ]
do 
	sleep 500;
done