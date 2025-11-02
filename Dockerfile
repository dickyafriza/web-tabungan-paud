# syntax=docker/dockerfile:1
FROM php:8.2-fpm

# set working dir
WORKDIR /var/www/html

# system deps
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libxml2-dev \
    libpq-dev \
    gnupg2 \
    ca-certificates \
    procps \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# php extensions
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl bcmath gd

# install composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# nodejs (optional for npm / vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm i -g npm@latest

# copy existing application code
COPY . /var/www/html

# set permissions (will be adjusted on container start if needed)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache || true

# expose php-fpm port (nginx will connect to it)
EXPOSE 9000

# default command
CMD ["php-fpm"]
