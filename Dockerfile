FROM php:8.1.13-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    zip \
    git \
    curl \
    unzip \
    wget \
    libxrender1 \
    libxtst6 \
    fontconfig \
    libjpeg62-turbo \
    xfonts-75dpi \
    xfonts-base \
    libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install mbstring \
    && docker-php-source delete \

# Copy config files
COPY ./.docker/php/php.ini /usr/local/etc/php/php.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Postgre PDO
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
RUN   echo "ServerName localhost" >> /etc/apache2/apache2.conf
EXPOSE 80
