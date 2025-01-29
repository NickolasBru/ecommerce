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

# Install PECL extension for HTTP (ext-http)
RUN pecl install pecl_http && docker-php-ext-enable http || true

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application files
COPY src /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www/storage

# Ensure correct permissions for Laravel storage and bootstrap cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Install Laravel dependencies and force update composer
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction

# Switch back to a non-root user for security
USER www-data

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
