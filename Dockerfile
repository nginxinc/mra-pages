FROM ubuntu:14.04

# Set the debconf front end to Noninteractive
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

# persistent / runtime deps
RUN apt-get update && apt-get install -y \
    ca-certificates \
    curl \
    librecode0 \
    libsqlite3-0 \
    libxml2 \
    --no-install-recommends \
    && rm -r /var/lib/apt/lists/*

# phpize deps
RUN apt-get update && apt-get install -y \
	autoconf \
	file \
	g++ \
	gcc \
	libc-dev \
	make \
	pkg-config \
	re2c \
    wget \
    jq \
    apt-transport-https \
    libcurl3-gnutls \
    lsb-release \
    apt-utils \
    python \
	--no-install-recommends \
	&& rm -r /var/lib/apt/lists/*

ENV PHP_INI_DIR /usr/local/etc/php
RUN mkdir -p $PHP_INI_DIR/conf.d

##<autogenerated>##
ENV PHP_EXTRA_CONFIGURE_ARGS --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data
##</autogenerated>##

ENV GPG_KEYS 0B96609E270F565C13292B24C13C70B87267B52D 0BD78B5F97500D450838F95DFE857D9A90D90EC1 F38252826ACD957EF380D39F2F7956BC5DA04B5D
RUN set -xe \
	&& for key in $GPG_KEYS; do \
		gpg --keyserver ha.pool.sks-keyservers.net --recv-keys "$key"; \
	done

ENV PHP_VERSION 5.5.30

# --enable-mysqlnd is included below because it's harder to compile after the fact the extensions are (since it's a plugin for several extensions, not an extension in itself)
RUN buildDeps=" \
		$PHP_EXTRA_BUILD_DEPS \
		libcurl4-openssl-dev \
		libreadline6-dev \
		librecode-dev \
		libsqlite3-dev \
		libssl-dev \
		libxml2-dev \
		xz-utils \
	" \
	&& set -x \
	&& apt-get update && apt-get install -y $buildDeps --no-install-recommends && rm -rf /var/lib/apt/lists/* \
	&& curl -SL "http://php.net/get/php-$PHP_VERSION.tar.xz/from/this/mirror" -o php.tar.xz \
	&& curl -SL "http://php.net/get/php-$PHP_VERSION.tar.xz.asc/from/this/mirror" -o php.tar.xz.asc \
	&& gpg --verify php.tar.xz.asc \
	&& mkdir -p /usr/src/php \
	&& tar -xof php.tar.xz -C /usr/src/php --strip-components=1 \
	&& rm php.tar.xz* \
	&& cd /usr/src/php \
	&& ./configure \
		--with-config-file-path="$PHP_INI_DIR" \
		--with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
		$PHP_EXTRA_CONFIGURE_ARGS \
		--disable-cgi \
		--enable-mysqlnd \
		--with-curl \
		--with-openssl \
		--with-readline \
		--with-recode \
		--with-zlib \
		--enable-zip \
	&& make -j"$(nproc)" \
	&& make install \
	&& { find /usr/local/bin /usr/local/sbin -type f -executable -exec strip --strip-all '{}' + || true; } \
	&& apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $buildDeps \
	&& make clean

COPY docker-php-ext-* /usr/local/bin/

# Download certificate and key from the customer portal (https://cs.nginx.com)
# and copy to the build context
ADD nginx-repo.crt /etc/ssl/nginx/
ADD nginx-repo.key /etc/ssl/nginx/

## Download certificate and key from the the vault and copy to the build context
ARG VAULT_TOKEN
RUN mkdir -p /etc/ssl/nginx
#RUN wget -q -O - --header="X-Vault-Token: $VAULT_TOKEN" \
#    http://vault.ngra.ps.nginxlab.com:8200/v1/secret/nginx-repo.crt \
#    | jq -r .data.value > /etc/ssl/nginx/nginx-repo.crt
#RUN wget -q -O - --header="X-Vault-Token: $VAULT_TOKEN" \
#    http://vault.ngra.ps.nginxlab.com:8200/v1/secret/nginx-repo.key \
#    | jq -r .data.value > /etc/ssl/nginx/nginx-repo.key

# Download NGINX Plus
RUN wget -q -O /etc/ssl/nginx/CA.crt https://cs.nginx.com/static/files/CA.crt && \
    wget -q -O - http://nginx.org/keys/nginx_signing.key | apt-key add - && \
    wget -q -O /etc/apt/apt.conf.d/90nginx https://cs.nginx.com/static/files/90nginx && \
    printf "deb https://plus-pkgs.nginx.com/debian `lsb_release -cs` nginx-plus\n" >/etc/apt/sources.list.d/nginx-plus.list

RUN apt-get update && apt-get install -y nginx-plus-extras


# The direct approach
#RUN apt-get update && apt-get install -y \
#    wget \
#    apt-transport-https \
#    python
#
#RUN wget -q -O /etc/ssl/nginx/CA.crt https://cs.nginx.com/static/files/CA.crt && \
#    wget -q -O - http://nginx.org/keys/nginx_signing.key | apt-key add - && \
#    wget -q -O /etc/apt/apt.conf.d/90nginx https://cs.nginx.com/static/files/90nginx && \
#    printf "deb https://plus-pkgs.nginx.com/ubuntu `lsb_release -cs` nginx-plus\n" >/etc/apt/sources.list.d/nginx-plus.list
#
## Install NGINX Plus
#RUN apt-get update && apt-get install -y nginx-plus
#
# forward request logs to Docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log && \
    ln -sf /dev/stdout /var/log/nginx/error.log

RUN chown -R nginx /var/log/nginx/

COPY ./php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY ./nginx-* /etc/nginx/
COPY ./php-start.sh /php-start.sh
COPY ./composer.phar /composer.phar
COPY ./*.pem /etc/ssl/nginx/

RUN curl -sS https://getcomposer.org/installer | php
RUN php composer.phar require guzzlehttp/guzzle:~6.0

COPY ./inginious-pages/ /inginious-pages
RUN ln -sf /dev/stdout /inginious-pages/app/logs/prod.log && \
    chown -R nginx:www-data /inginious-pages/ && \
    chmod -R 775 /inginious-pages && \
    chmod -R 666 /inginious-pages/app/logs/prod.log
COPY ./php.ini /usr/local/etc/php/

COPY ./amplify_install.sh /amplify_install.sh
RUN API_KEY='0202c79a3d8411fcf82b35bc3d458f7e' HOSTNAME='pages' sh ./amplify_install.sh

CMD ["/php-start.sh"]

EXPOSE 443
