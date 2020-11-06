FROM node

MAINTAINER Juri Hahn <docker@hahn21.de>

RUN apt-get update -y && \
apt-get upgrade -y && \
apt-get install -y zlib1g-dev php php-zip php-xml php-curl

RUN cd / && npm install node-minify

COPY update.php /update.php
