#!/bin/bash

wget -O /usr/local/sbin/generate_config -q https://s3-us-west-1.amazonaws.com/fabric-model/config-generator/generate_config
chmod +x /usr/local/sbin/generate_config

CONFIG_FILE=/etc/nginx/fabric/fabric_config.yaml

case "$CONTAINER_ENGINE" in
    kubernetes)
        CONFIG_FILE=/etc/nginx/fabric/fabric_config_k8s.yaml
        ;;
    local)
        CONFIG_FILE=/etc/nginx/fabric/fabric_config_local.yaml
        ;;
esac

if [ "$USE_NGINX_PLUS" = true ];
then
  /usr/local/sbin/generate_config -p ${CONFIG_FILE} -t /etc/nginx/nginx-plus-fabric.conf.j2 > /etc/nginx/nginx.conf
else
    /usr/local/sbin/generate_config -p ${CONFIG_FILE} -t /etc/nginx/nginx-fabric.conf.j2 > /etc/nginx/nginx.conf
fi

/usr/local/sbin/generate_config -p ${CONFIG_FILE} -t /etc/nginx/default-location.conf.j2 > /etc/nginx/default-location.conf
