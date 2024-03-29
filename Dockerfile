FROM abiosoft/caddy:php-no-stats

RUN composer require aws/aws-sdk-php

RUN mkdir /srv/logs

ADD http://momentjs.com/downloads/moment.min.js /srv/m/moment.min.js
ADD https://cdn.jsdelivr.net/npm/ractive /srv/h/ractive.min.js

ADD Caddyfile /etc/Caddyfile

ARG COMMIT
ENV COMMIT ${COMMIT}

ADD config.php /srv
ADD aws-helpers.php /srv

ADD index /srv/index
# d.$HOST - docs
ADD docs /srv/docs
# m.$HOST - for managers
ADD m /srv/m
# h.$HOST - for home owners
ADD h /srv/h
# g.$HOST for guards
ADD g /srv/g

USER root
RUN chmod -R a+rx /srv/

VOLUME /srv/data
