FROM php:8.1-apache

# Install required PHP extensions (add mysqli here)
RUN docker-php-ext-install mysqli

# Enable Apache rewrite (optional)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files into container
COPY . .

# Fix Apache default root to /php folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/php|g' /etc/apache2/sites-available/000-default.conf

# Add fallback index if none exists (optional)
RUN test -f php/index.php || echo "<?php phpinfo(); ?>" > php/index.php

EXPOSE 80
