FROM php:7.0.31-fpm

RUN useradd --create-home -s /bin/bash pages

ARG CONTAINER_ENGINE_ARG
ARG USE_NGINX_PLUS_ARG
ARG USE_VAULT_ARG
ARG NETWORK_ARG

# CONTAINER_ENGINE specifies the container engine to which the
# containers will be deployed. Valid values are:
# - kubernetes (default)
# - mesos
# - local
ENV USE_NGINX_PLUS=${USE_NGINX_PLUS_ARG:-true} \
    USE_VAULT=${USE_VAULT_ARG:-false} \
    SYMFONY_ENV=dev \
    CONTAINER_ENGINE=${CONTAINER_ENGINE_ARG:-kubernetes} \
    NETWORK=${NETWORK_ARG:-fabric}

# Get other files required for installation
RUN apt-get update && apt-get install -y \
    wget \
    apt-transport-https \
    vim \
    libcurl3-gnutls \
    lsb-release \
    unzip \
    ca-certificates \
    gnupg \
    build-essential \
    libssl-dev

# Install NGINX and forward request logs to Docker log collector
COPY nginx /etc/nginx/
COPY nginx/ssl /etc/ssl/nginx/
ADD install-nginx.sh /usr/local/bin/
RUN /usr/local/bin/install-nginx.sh && \
    ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log && \
    yes | pecl install xdebug

# install application
COPY ingenious-pages/ /ingenious-pages

WORKDIR /ingenious-pages

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt install -y nodejs

RUN php composer.phar install --no-dev --optimize-autoloader && \
    chown -R nginx:www-data /ingenious-pages/ && \
    chmod -R 777 /ingenious-pages && \
    cd less-css && \
    npm install gulp-cli -g && \
    npm install gulp -D && \
    npm install gulp-less -D && \
    gulp less

RUN wget -O phpunit https://phar.phpunit.de/phpunit-5.phar && \
    chmod +x phpunit && \
    ./phpunit -v

COPY php5-fpm-fabric.conf php5-fpm-router-proxy.conf /etc/php5/fpm/
COPY php.ini /usr/local/etc/php/

COPY php-start.sh /php-start.sh

RUN chmod -R 777 /ingenious-pages

CMD ["/php-start.sh"]

EXPOSE 80 443
