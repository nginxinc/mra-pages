#!/bin/sh
pid="/var/run/nginx.pid";    # /   (root directory)
fpm_pid="/var/run/php-fpm.pid";
nginx_conf="/etc/nginx/nginx.conf";

echo "Starting ${nginx_conf} with pid ${pid}"

nginx -c "$nginx_conf" -g "pid $pid;" &

echo "FPM PID ${fpm_pid}"

php-fpm -y /etc/php5/fpm/php-fpm.conf -R &

################----AN UGLY HACK TO DEAL WITH DOCKERCLOUD'S RELIANCE ON SEARCH DOMAINS---################
#SEARCH_DOMAIN=`cat /etc/resolv.conf | awk -F " " '/search/ {print $2}'`
#echo `curl "http://localhost/upstream_conf?add=&upstream=router-mesh&server=router-mesh.$SEARCH_DOMAIN"`
#echo `curl "http://localhost/upstream_conf?remove=&upstream=router-mesh&id=0"`
#########################################################################################################

echo launched processes;
sleep 10;

while [ -f "$pid" ] &&  [ -f "$fpm_pid" ];
do
	sleep 5;
    #echo in the while loop;
done