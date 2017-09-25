FROM php:7.0.5-fpm

ENV USE_NGINX_PLUS=true \
    USE_VAULT=false \
    SYMFONY_ENV=prod \
# CONTAINER_ENGINE specifies the container engine to which the
# containers will be deployed. Valid values are:
# - kubernetes
# - mesos (default)
# - local
#    CONTAINER_ENGINE=kubernetes

COPY nginx/ssl /etc/ssl/nginx/
COPY vault_env.sh /etc/letsencrypt/
# Get other files required for installation
RUN apt-get update && apt-get install -y \
    wget \
    curl \
    apt-transport-https \
    vim \
    libcurl3-gnutls \
    lsb-release \
    unzip \
    ca-certificates

# Install NGINX Plus
COPY nginx /etc/nginx/
ADD install-nginx.sh /usr/local/bin/
RUN /usr/local/bin/install-nginx.sh && \
# forward request logs to Docker log collector
    ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
# Install XDebug
    yes | pecl install xdebug

# install application
COPY ingenious-pages/ /ingenious-pages

RUN cd /ingenious-pages && \
    php composer.phar install --no-dev --optimize-autoloader && \
    ln -sf /dev/stdout /ingenious-pages/app/logs/prod.log && \
    chown -R nginx:www-data /ingenious-pages/ && \
    chmod -R 775 /ingenious-pages

COPY php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY php.ini /usr/local/etc/php/

COPY php-start.sh /php-start.sh

CMD ["/php-start.sh"]

EXPOSE 80 443