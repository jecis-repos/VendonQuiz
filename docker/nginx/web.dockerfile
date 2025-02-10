FROM nginx:1.25.0-alpine

RUN  apk update \
    && apk add --no-cache \
    nginx \
    openssl \
    pv \
    fish \
    && apk add --no-cache --virtual .build-deps \
    && rm -rf /var/cache/apk/*
ADD docker/nginx/conf.d/vhost.conf  /etc/nginx/conf.d/default.conf
ADD docker/export/server.crt /etc/nginx/conf.d/server.crt
ADD docker/export/server.key /etc/nginx/certs/server.key
ADD docker/nginx/nginx.conf /etc/nginx/nginx.conf
