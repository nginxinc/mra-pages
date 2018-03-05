#!/bin/sh
fpm_pid="/var/run/php-fpm.pid";

# Temporary solution - start NGINX as well in router-mesh to serve static files
# if [ "$NETWORK" = "fabric" ]
# then
    pid="/var/run/nginx.pid";    # /   (root directory)
    nginx_conf="/etc/nginx/nginx.conf";
    echo fabric configuration set;
    echo "Starting ${nginx_conf} with pid ${pid}"
    nginx -c "$nginx_conf" -g "pid $pid;" &
# fi

echo "FPM PID ${fpm_pid}"

php-fpm -y /etc/php5/fpm/php-fpm.conf -R &

################----AN UGLY HACK TO DEAL WITH DOCKERCLOUD'S RELIANCE ON SEARCH DOMAINS---################
#SEARCH_DOMAIN=`cat /etc/resolv.conf | awk -F " " '/search/ {print $2}'`
#echo `curl "http://localhost/upstream_conf?add=&upstream=router-mesh&server=router-mesh.$SEARCH_DOMAIN"`
#echo `curl "http://localhost/upstream_conf?remove=&upstream=router-mesh&id=0"`
#########################################################################################################

echo launched processes;
sleep 10;

if [ "$NETWORK" = "fabric" ]
then
    while [ -f "$pid" ] &&  [ -f "$fpm_pid" ];
    do
	    sleep 5;
    done
else
    while [ -f "$fpm_pid" ];
    do
	    sleep 5;
    done
fi