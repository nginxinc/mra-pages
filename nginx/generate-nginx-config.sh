#!/bin/bash

wget -O /usr/local/sbin/generate_config -q https://s3-us-west-1.amazonaws.com/fabric-model/config-generator/generate_config
chmod +x /usr/local/sbin/generate_config

FABRIC_TEMPLATE_FILE="/etc/nginx/fabric/fabric_nginx-plus.conf.j2"

if [ "$USE_NGINX_PLUS" = false ];
then
    FABRIC_TEMPLATE_FILE="/etc/nginx/fabric/fabric_nginx.conf.j2"
fi

echo Generating NGINX configurations...


CONFIG_FILE=/etc/nginx/fabric/fabric_config.yaml

case "$CONTAINER_ENGINE" in
    kubernetes)
        CONFIG_FILE=/etc/nginx/fabric/fabric_config_k8s.yaml
        ;;
    local)
        CONFIG_FILE=/etc/nginx/fabric/fabric_config_local.yaml
        ;;
esac

/usr/local/sbin/generate_config -p ${CONFIG_FILE} -t ${FABRIC_TEMPLATE_FILE} > /etc/nginx/nginx.conf

/usr/local/sbin/generate_config -p ${CONFIG_FILE} -t /etc/nginx/default-location.conf.j2 > /etc/nginx/default-location.conf
