## Composer Install Stage
FROM composer:2 as composer_build

RUN rm -rf /var/www && mkdir -p /var/www/html
WORKDIR /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY composer.json composer.lock symfony.lock .env ./

COPY public public/

RUN set -xe \
    && composer install --ignore-platform-reqs --prefer-dist --no-scripts --no-progress --no-interaction --no-dev --no-autoloader

RUN set -eux \
	&& composer dump-autoload --optimize --apcu --no-dev;

COPY bin bin/
COPY config config/
COPY templates templates/
COPY src src/

RUN set -eux; \
	    mkdir -p var/cache var/log var/session

RUN rm -rf var/cache/* var/build/*
RUN php -d memory_limit=-1 bin/console cache:warmup

RUN chmod g+s /var/www/html/var
RUN chown -R www-data /var/www/html/var;

## Webpack install + compilation stage
FROM node:12 as encore_builder

COPY --from=composer /var/www/html /var/www/html

WORKDIR /var/www/html
COPY yarn.lock package.json webpack.config.js ./
COPY assets ./assets

RUN yarn install
RUN yarn encore prod

## Install roadrunner to serve application

FROM spiralscout/roadrunner:2.10.4 AS roadrunner
FROM php:8.1-cli

WORKDIR /var/www/html

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr
COPY --from=composer_build /var/www/html /var/www/html
COPY .env .rr.yaml /var/www/html/

EXPOSE 18997

CMD ["rr", "serve", "-c", ".rr.yaml"]
