FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Install PHP dependencies (Cloudinary etc.)
RUN composer install

# Enable necessary Apache modules
RUN a2enmod rewrite headers mime

# Allow .htaccess to override Apache config
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Set default homepage to index.php
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

EXPOSE 80