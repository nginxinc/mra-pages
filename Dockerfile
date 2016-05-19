FROM php:7.0.5-fpm

RUN apt-get update && apt-get install -y \
    apt-transport-https \
    git \
    libcurl3-gnutls \
    lsb-release \
    python \
    unzip \
    wget

# New Relic dependencies
ENV NR_INSTALL_SILENT=1 \
    NR_INSTALL_KEY=30d86de372edded790894f46704b09866ed3e1c5 \
    NR_INSTALL_PHPLIST=/usr/local/bin

RUN echo newrelic-php5 newrelic-php5/application-name string "Pages" | debconf-set-selections && \
		wget -O - https://download.newrelic.com/548C16BF.gpg | apt-key add - && \
		sh -c 'echo "deb http://apt.newrelic.com/debian/ newrelic non-free" > /etc/apt/sources.list.d/newrelic.list'

# Install vault client
RUN wget -q https://releases.hashicorp.com/vault/0.5.2/vault_0.5.2_linux_amd64.zip && \
	  unzip -d /usr/local/bin vault_0.5.2_linux_amd64.zip

# Download certificate and key from the the vault and copy to the build context
ENV VAULT_TOKEN=4b9f8249-538a-d75a-e6d3-69f5355c1751 \
    VAULT_ADDR=http://vault.ngra.ps.nginxlab.com:8200

RUN mkdir -p /etc/ssl/nginx && \
	  vault token-renew && \
	  vault read -field=value secret/nginx-repo.crt > /etc/ssl/nginx/nginx-repo.crt && \
	  vault read -field=value secret/nginx-repo.key > /etc/ssl/nginx/nginx-repo.key

RUN wget -q -O /etc/ssl/nginx/CA.crt https://cs.nginx.com/static/files/CA.crt && \
    wget -q -O - http://nginx.org/keys/nginx_signing.key | apt-key add - && \
    wget -q -O /etc/apt/apt.conf.d/90nginx https://cs.nginx.com/static/files/90nginx && \
    printf "deb https://plus-pkgs.nginx.com/debian `lsb_release -cs` nginx-plus\n" | tee /etc/apt/sources.list.d/nginx-plus.list

# Install NGINX Plus and New Relic
RUN apt-get update && apt-get install -y \
    nginx-plus \
    newrelic-php5

# forward request logs to Docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stdout /var/log/nginx/error.log

RUN chown -R nginx /var/log/nginx/

COPY php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY php.ini /usr/local/etc/php/
COPY nginx-php.conf /etc/nginx/
COPY php-start.sh /php-start.sh

COPY amplify_install.sh /amplify_install.sh
RUN API_KEY='0202c79a3d8411fcf82b35bc3d458f7e' HOSTNAME='pages' sh /amplify_install.sh

# Install XDebug
# RUN yes | pecl install xdebug \
#     && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#     && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# install application
ENV SYMFONY_ENV=prod
COPY inginious-pages/ /inginious-pages
RUN chown -R nginx:www-data /inginious-pages/ && chmod -R 775 /inginious-pages
RUN cd /inginious-pages && php composer.phar install --no-dev --optimize-autoloader

CMD ["/php-start.sh"]

EXPOSE 80
