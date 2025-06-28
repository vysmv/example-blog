FROM php:fpm

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN apt-get update && apt-get install -y \
    curl \
    procps \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    cron \
    supervisor \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql zip gd intl mbstring xml \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && pecl install redis && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf

WORKDIR /app
