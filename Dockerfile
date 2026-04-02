# ⚙️ Dockerfile - Les Saveurs Du Jardin (Symfony 7)

# --- Stage 1: Build & Dependencies ---
FROM php:8.2-fpm-alpine as base

# Install system dependencies
RUN apk add --no-cache \
    bash \
    icu-dev \
    libzip-dev \
    zlib-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    mysql-client \
    git \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    intl \
    pdo_mysql \
    zip \
    gd \
    opcache

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# --- Stage 2: Development ---
FROM base as dev

# Set Env
ENV APP_ENV=dev

# Copy composer files
COPY composer.* ./

# Install dev dependencies
RUN composer install --no-scripts --no-autoloader

# Entrypoint for Dev
CMD ["php-fpm"]

# --- Stage 3: Production Builds ---
FROM base as prod

# Optimized PHP config
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/prod.ini $PHP_INI_DIR/conf.d/prod.ini

# Set Env
ENV APP_ENV=prod

# Copy application source
COPY . .

# Production Install
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Permissions
RUN chown -R www-data:www-data /var/www/html/var

CMD ["php-fpm"]
