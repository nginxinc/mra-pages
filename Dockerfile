FROM php:7.0.5-fpm

# Get other files required for installation
RUN apt-get update && apt-get install -y \
    wget \
    curl \
    apt-transport-https \
    vim \
    libcurl3-gnutls \
    lsb-release \
    unzip \
    ca-certificates \
    nodejs \
    npm \
    phpunit

RUN yes | pecl install xdebug

# install application
COPY ingenious-pages/ /ingenious-pages

RUN cd /ingenious-pages && \
    php composer.phar install --no-dev --optimize-autoloader && \
    ln -s /usr/bin/nodejs /usr/bin/node && \
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