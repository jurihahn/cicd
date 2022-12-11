FROM node

MAINTAINER Juri Hahn <docker@hahn21.de>

RUN apt-get update -y && \
apt-get upgrade -y && \
apt-get install -y zlib1g-dev php php-zip php-xml php-curl ca-certificates openssl zip curl php-cli php-mbstring git unzip

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN mkdir /cicd && chmod 777 cicd && cd /cicd && npm install node-minify

COPY update.php /cicd/update.php
