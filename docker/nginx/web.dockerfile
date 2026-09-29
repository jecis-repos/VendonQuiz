FROM nginx:stable-alpine
COPY docker/nginx/conf.d/vhost.conf /etc/nginx/conf.d/default.conf
