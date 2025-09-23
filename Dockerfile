FROM jkaninda/nginx-php-fpm:8.2

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install pdo_pgsql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies
RUN composer require google/apiclient
RUN composer install --ignore-platform-req=ext-intl

# Copy nginx configuration file
COPY nginx.conf /var/www/html/conf/nginx/nginx-site.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www/html
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan storage:link
# RUN php artisan migrate

# Expose port 80
EXPOSE 80

# CMD is already set in the base image to start Nginx and PHP-FPM
