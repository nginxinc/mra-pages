#!/bin/sh
NGINX_PID="/var/run/nginx.pid";    # /   (root directory)
NGINX_CONF="";
fpm_pid="/var/run/php-fpm.pid";

echo "FPM PID ${fpm_pid}"

################----AN UGLY HACK TO DEAL WITH DOCKERCLOUD'S RELIANCE ON SEARCH DOMAINS---################
#SEARCH_DOMAIN=`cat /etc/resolv.conf | awk -F " " '/search/ {print $2}'`
#echo `curl "http://localhost/upstream_conf?add=&upstream=router-mesh&server=router-mesh.$SEARCH_DOMAIN"`
#echo `curl "http://localhost/upstream_conf?remove=&upstream=router-mesh&id=0"`
#########################################################################################################

case "$NETWORK" in
    fabric)
        php-fpm -y /etc/php/fpm/php5-fpm-fabric.conf -R &
        echo launched processes;
        sleep 10;

        php /ingenious-pages/Insert.php &

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
        php-fpm -y /etc/php/fpm/php5-fpm-router-proxy.conf -R &
        echo launched processes;
        sleep 10;

        php /ingenious-pages/Insert.php &

        while [ -f "$fpm_pid" ];
        do
            sleep 5;
        done
        ;;
    proxy)
        ;;
    *)
        echo 'Network not supported'
        exit 1
esac

