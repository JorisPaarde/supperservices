FROM composer AS composer

FROM webdevops/php-nginx:7.4-alpine as composer_install
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Get args
ARG COMPOSER_AUTH
ARG ENV_PROJECT

# Set env
ENV COMPOSER_AUTH=$COMPOSER_AUTH

# Copying the source directory and install the dependencies with composer
COPY . /app

WORKDIR /app

# Run composer install to install the dependencies
RUN composer install \
 --optimize-autoloader \
 --no-interaction \
 --no-progress \
 --prefer-dist \
 --no-dev

# Go to theme folder
WORKDIR /app/web/app/themes/supper-saves

# Install composer dependencies
RUN composer install \
 --optimize-autoloader \
 --no-interaction \
 --no-progress \
 --prefer-dist \
 --no-dev

# Install NPM dependencies and build assets
FROM node:14 as npm_builder
COPY --from=composer_install /app /app

WORKDIR /app/web/app/themes/supper-saves

RUN npm ci --no-audit
RUN npm run production
RUN npm cache clean --force
RUN rm -rf node_modules

# Continue stage build with the desired image
FROM webdevops/php-nginx:7.4-alpine
COPY --chown=application:application --from=npm_builder /app /app
RUN rm -rf /opt/docker/etc/nginx/vhost.conf
COPY vhost.conf /opt/docker/etc/nginx/vhost.conf
