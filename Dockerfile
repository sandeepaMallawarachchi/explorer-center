FROM php:8.1-apache

# Enable Apache rewrite (optional, useful for .htaccess/Laravel)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy everything to Apache root
COPY . .

# Set Apache's default directory to /php
RUN echo "DocumentRoot /var/www/html/php" >> /etc/apache2/apache2.conf

EXPOSE 80
