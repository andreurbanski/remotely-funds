# Use an official PHP 8.2 image as the base image
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    postgresql-client \
    libicu-dev # Install the ICU library required for ext-intl

# Install the PHP intl extension
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl pdo pdo_pgsql

RUN pecl install redis

# Install Xdebug !! DISABLE BEFORE COMMIT
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Xdebug configuration
COPY ./server/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY ./server/php/php.ini /usr/local/etc/php/conf.d/php.ini
#COPY ./server/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY ./server/php/php-fpm.custom /usr/local/etc/php-fpm/php-fpm.d/php-fpm.custom

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory to /app
WORKDIR /app

# Copy the application code into the container
COPY ./src /app

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install application dependencies using Composer
RUN composer install

# Expose a port if your application runs a web server
# For example, if your application uses Apache, you might expose port 80
# EXPOSE 80

WORKDIR /app/src

# Define the command to start your application
# For example, if you're using PHP's built-in web server:



CMD ["php", "artisan", "serve",  "--host=0.0.0.0", "--port=7777"]
