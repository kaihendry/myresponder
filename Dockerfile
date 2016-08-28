FROM abiosoft/caddy:php
MAINTAINER Kai Hendry <hendry@iki.fi>

RUN composer require aws/aws-sdk-php
ADD Caddyfile /etc/Caddyfile

RUN mkdir /srv/logs

ADD config.php /srv

ADD index /srv/index
# d.$HOST - docs
ADD docs /srv/docs
# m.$HOST - for managers
ADD m /srv/m
# h.$HOST - for home owners
ADD h /srv/h
# g.$HOST for guards
ADD g /srv/g

ADD http://momentjs.com/downloads/moment.min.js /srv/m/moment.min.js
ADD http://cdn.ractivejs.org/latest/ractive.min.js /srv/h/ractive.min.js

ARG COMMIT
ENV COMMIT ${COMMIT}

VOLUME /srv/data
