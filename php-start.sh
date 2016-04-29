#!/bin/sh
pid="/var/run/nginx.pid";    # /   (root directory)
fpm_pid="/var/run/php-fpm.pid";
nginx_conf="/etc/nginx/nginx-php.conf";
nginx_fabric="/etc/nginx/nginx-fabric.conf";

if [ "$FABRIC" = "true" ]
then
    $nginx_conf = $nginx_fabric;
    echo fabric configuration set;
fi

nginx -c $nginx_conf -g "pid $pid;" &

service amplify-agent start;

php-fpm -y /etc/php5/fpm/php-fpm.conf -R &

echo launched processes;
sleep 10;

while [ -f "$pid" ] &&  [ -f "$fpm_pid" ];
do
	sleep 5;
    #echo in the while loop;
done