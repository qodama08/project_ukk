FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Copy .env.example to .env if .env does not exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Install dependencies, generate app key, migrate (optional)
RUN composer install --no-interaction --prefer-dist && \
    php artisan key:generate && \
    php artisan migrate --seed || true && \
    chown -R www-data:www-data storage bootstrap/cache

# Ensure php-fpm listens on all interfaces (so nginx can reach it from another container)
RUN sed -i "s/listen = 127.0.0.1:9000/listen = 9000/" /usr/local/etc/php-fpm.d/www.conf || true

# Expose port 9000 and start PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
