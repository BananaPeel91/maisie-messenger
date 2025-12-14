FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock* ./

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Run post-install scripts
RUN composer dump-autoload --optimize

# Create storage directories
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 8000

# Start the Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

