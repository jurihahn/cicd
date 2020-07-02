FROM node

MAINTAINER Juri Hahn <docker@hahn21.de>

RUN apt-get update -y && apt-get upgrade -y && apt-get install -y zlib1g-dev php php-zip && npm install -g node-minify
