ARG COMPOSER_VERSION
ARG PHP_VERSION
ARG EXTENSION_INSTALLER_VERSION

FROM composer:${COMPOSER_VERSION} AS composer
FROM mlocati/php-extension-installer:${EXTENSION_INSTALLER_VERSION} AS extensions

FROM php:${PHP_VERSION}-cli-alpine AS php

COPY --from=composer    /usr/bin/composer /usr/bin/composer
COPY --from=extensions  /usr/bin/install-php-extensions /usr/bin/install-php-extensions

RUN install-php-extensions xdebug

WORKDIR /app/
