FROM nginx:1-alpine

ADD vhost.conf /etc/nginx/conf.d/default.conf