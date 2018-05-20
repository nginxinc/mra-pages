#!/bin/sh
NGINX_PID="/var/run/nginx.pid";    # /   (root directory)
NGINX_CONF="";
fpm_pid="/var/run/php-fpm.pid";

echo "FPM PID ${fpm_pid}"

php-fpm -y /etc/php5/fpm/php-fpm.conf -R &

################----AN UGLY HACK TO DEAL WITH DOCKERCLOUD'S RELIANCE ON SEARCH DOMAINS---################
#SEARCH_DOMAIN=`cat /etc/resolv.conf | awk -F " " '/search/ {print $2}'`
#echo `curl "http://localhost/upstream_conf?add=&upstream=router-mesh&server=router-mesh.$SEARCH_DOMAIN"`
#echo `curl "http://localhost/upstream_conf?remove=&upstream=router-mesh&id=0"`
#########################################################################################################

echo launched processes;
sleep 10;

case "$NETWORK" in
    fabric)
        NGINX_CONF="/etc/nginx/fabric_nginx_$CONTAINER_ENGINE.conf"
        echo 'Fabric configuration set'
        nginx -c "$NGINX_CONF" -g "pid $NGINX_PID;" &

        sleep  20
        while [ -f "$NGINX_PID" ] &&  [ -f "$fpm_pid" ];
        do
	        sleep 5;
        done
        ;;
    router-mesh)
        while [ -f "$fpm_pid" ];
        do
	        sleep 5;
        done
        ;;
    *)
        echo 'Network not supported'
        exit 1
esac
