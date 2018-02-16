FROM php:7.0.5-fpm

ARG CONTAINER_ENGINE_ARG
ARG USE_NGINX_PLUS_ARG
ARG USE_VAULT_ARG

# CONTAINER_ENGINE specifies the container engine to which the
# containers will be deployed. Valid values are:
# - kubernetes (default)
# - mesos
# - local
ENV USE_NGINX_PLUS=${USE_NGINX_PLUS_ARG:-true} \
    USE_VAULT=${USE_VAULT_ARG:-false} \
    SYMFONY_ENV=prod \
    CONTAINER_ENGINE=${CONTAINER_ENGINE_ARG:-kubernetes}

COPY nginx/ssl /etc/ssl/nginx/

# Get other files required for installation
RUN apt-get update && apt-get install -y \
    wget \
    php5-curl \
    apt-transport-https \
    vim \
    libcurl3-gnutls \
    lsb-release \
    unzip \
    ca-certificates \
    nodejs \
    npm \
    phpunit

# Install NGINX and forward request logs to Docker log collector
COPY nginx /etc/nginx/
ADD install-nginx.sh /usr/local/bin/
RUN /usr/local/bin/install-nginx.sh && \
    ln -sf /dev/stdout /var/log/nginx/access_log && \
    ln -sf /dev/stderr /var/log/nginx/error_log && \
    yes | pecl install xdebug

# install application
COPY ingenious-pages/ /ingenious-pages

RUN cd /ingenious-pages && \
    php composer.phar install --no-dev --optimize-autoloader && \
    ln -s /usr/bin/nodejs /usr/bin/node && \
    chown -R nginx:www-data /ingenious-pages/ && \
    chmod -R 775 /ingenious-pages && \
    cd less-css && \
    npm install gulp-cli -g && \
    npm install gulp -D && \
    npm install gulp-less -D && \
    gulp less && \
    cd /ingenious-pages && \
    phpunit -v

COPY php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY php.ini /usr/local/etc/php/

COPY php-start.sh /php-start.sh

CMD ["/php-start.sh"]

EXPOSE 80 443