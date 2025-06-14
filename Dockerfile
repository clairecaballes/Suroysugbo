FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx supervisor curl git zip unzip \
    libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath xml

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Copy the startup script
COPY docker/startup.sh /docker/startup.sh

COPY .. /var/www

# Make the startup script executable
RUN chmod +x /docker/startup.sh

WORKDIR /var/www

# Ensure the necessary directories exist
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Set permissions for the directories
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port
# EXPOSE 80

# Start both services
CMD ["sh", "/docker/startup.sh"]