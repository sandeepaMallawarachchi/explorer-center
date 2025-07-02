FROM php:8.1-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy everything to Apache root
COPY . .

# Set correct DocumentRoot to /var/www/html/php
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/php|g' /etc/apache2/sites-available/000-default.conf

# Add fallback index if needed
RUN test -f php/index.php || echo "<?php phpinfo(); ?>" > php/index.php

EXPOSE 80
