FROM php:8.0.8-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

RUN apk --update --no-cache add git
RUN apk add bash
RUN apk add make

RUN install-php-extensions opcache xdebug @composer
RUN install-php-extensions amqp intl

# Configure Xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini;

RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www
CMD composer install ; php-fpm
EXPOSE 9000