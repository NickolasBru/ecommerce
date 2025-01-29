# Use the official PHP 8.2 image with FPM
FROM php:8.2-fpm

# Switch to root user for package installation
USER root

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd curl

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY src /var/www

# Ensure correct permissions for Laravel storage and bootstrap cache
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www

# Install Laravel dependencies and force update composer
USER www-data
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction --ignore-platform-req=ext-http

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
