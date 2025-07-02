FROM php:8.1-apache

# Install mysqli for db.php
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy everything to Apache root
COPY . .

# (Optional) Use index.php as the homepage
RUN echo 'DirectoryIndex index.php' >> /etc/apache2/apache2.conf

EXPOSE 80
