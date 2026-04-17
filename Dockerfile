ARG PHP_VERSION=8.5
FROM php:${PHP_VERSION}-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

# Bind mounts are often owned by the host user; treat /app as a safe Git directory.
RUN git config --global --add safe.directory /app

WORKDIR /app
