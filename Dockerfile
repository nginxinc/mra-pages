FROM php:7.0.5-fpm

# Get other files required for installation
RUN apt-get update && apt-get install -y \
    wget \
    curl \
    apt-transport-https \
    git \
    libcurl3-gnutls \
    lsb-release \
    unzip \
    ca-certificates

# Install vault client
RUN wget -q https://releases.hashicorp.com/vault/0.6.0/vault_0.6.0_linux_amd64.zip && \
	  unzip -d /usr/local/bin vault_0.6.0_linux_amd64.zip

# Download certificate and key from the the vault and copy to the build context
ENV VAULT_TOKEN=4b9f8249-538a-d75a-e6d3-69f5355c1751 \
    VAULT_ADDR=http://vault.mra.nginxps.com:8200

RUN mkdir -p /etc/ssl/nginx && \
	vault token-renew && \
	vault read -field=value secret/nginx-repo.crt > /etc/ssl/nginx/nginx-repo.crt && \
	vault read -field=value secret/nginx-repo.key > /etc/ssl/nginx/nginx-repo.key && \
	vault read -field=value secret/ssl/csr.pem > /etc/ssl/nginx/csr.pem && \
	vault read -field=value secret/ssl/certificate.pem > /etc/ssl/nginx/certificate.pem && \
	vault read -field=value secret/ssl/key.pem > /etc/ssl/nginx/key.pem && \
	vault read -field=value secret/ssl/dhparam.pem > /etc/ssl/nginx/dhparam.pem

RUN wget -q -O /etc/ssl/nginx/CA.crt https://cs.nginx.com/static/files/CA.crt && \
    wget -q -O - http://nginx.org/keys/nginx_signing.key | apt-key add - && \
    wget -q -O /etc/apt/apt.conf.d/90nginx https://cs.nginx.com/static/files/90nginx && \
    printf "deb https://plus-pkgs.nginx.com/debian `lsb_release -cs` nginx-plus\n" | tee /etc/apt/sources.list.d/nginx-plus.list

# Install NGINX Plus
RUN apt-get update && apt-get install -y nginx-plus

RUN chown -R nginx /var/log/nginx/

# Install Amplify
RUN curl -sS -L -O  https://github.com/nginxinc/nginx-amplify-agent/raw/master/packages/install.sh && \
	API_KEY='0202c79a3d8411fcf82b35bc3d458f7e' AMPLIFY_HOSTNAME='mesos-pages' sh ./install.sh

# forward request logs to Docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stderr /var/log/nginx/error.log

# Install XDebug
RUN yes | pecl install xdebug

# install application
ENV SYMFONY_ENV=prod
COPY ingenious-pages/ /ingenious-pages

RUN ln -sf /dev/stdout /ingenious-pages/app/logs/prod.log && \
    chown -R nginx:www-data /ingenious-pages/ && \
    chmod -R 775 /ingenious-pages

RUN cd /ingenious-pages && php composer.phar install --no-dev --optimize-autoloader

COPY php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY php.ini /usr/local/etc/php/
COPY nginx /etc/nginx/

# Install and run NGINX config generator
RUN wget -q https://s3-us-west-1.amazonaws.com/fabric-model/config-generator/generate_config
RUN chmod +x generate_config && \
    ./generate_config -p /etc/nginx/fabric_config.yaml -t /etc/nginx/nginx-fabric.conf.j2 > /etc/nginx/nginx-fabric.conf

COPY php-start.sh /php-start.sh

CMD ["/php-start.sh"]

EXPOSE 80 443