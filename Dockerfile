# Use official PHP 8.1 CLI image
FROM php:8.1-cli

# Install system packages and PHP extensions you need
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libonig-dev \
 && docker-php-ext-install mbstring

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy your project files
COPY . .

# Default command: open a shell (for development)
CMD [ "bash" ]
