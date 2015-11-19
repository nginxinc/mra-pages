FROM ubuntu:14.04

MAINTAINER NGINX Docker Maintainers "docker-maint@nginx.com"

# Set the debconf front end to Noninteractive
RUN echo 'debconf debconf/frontend select Noninteractive' | debconf-set-selections

RUN apt-get update && apt-get install -y -q curl \
                                            wget \
                                            apt-transport-https \
                                            php5-cli \
                                            php5-common \
                                            #php5-suhosin \
                                            php5-fpm \
                                            php5-cgi

# Download certificate and key from the customer portal (https://cs.nginx.com)
# and copy to the build context
ADD nginx-repo.crt /etc/ssl/nginx/
ADD nginx-repo.key /etc/ssl/nginx/

# Get other files required for installation
RUN wget -q -O /etc/ssl/nginx/CA.crt https://cs.nginx.com/static/files/CA.crt
RUN wget -q -O - http://nginx.org/keys/nginx_signing.key | apt-key add -
RUN wget -q -O /etc/apt/apt.conf.d/90nginx https://cs.nginx.com/static/files/90nginx

RUN printf "deb https://plus-pkgs.nginx.com/ubuntu `lsb_release -cs` nginx-plus\n" >/etc/apt/sources.list.d/nginx-plus.list

# Install NGINX Plus
RUN apt-get update && apt-get install -y nginx-plus

# forward request logs to Docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stdout /var/log/nginx/error.log
RUN ln -sf /dev/stdout /var/log/php5-fpm.log

COPY ./nginx-php.conf /etc/nginx/
RUN chown -R nginx /var/log/nginx/

COPY ./php5-fpm.conf /etc/php5/fpm/php-fpm.conf
COPY ./inginious-pages/ /inginious-pages

RUN chown -R nginx:www-data /inginious-pages/
RUN chmod -R 775 /inginious-pages

CMD ["/inginious-pages/php-start.sh"]

#RUN chgrp nginx /var/run/php5-fpm.sock

EXPOSE 80 8000
