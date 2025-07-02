FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite headers mime

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Allow .htaccess
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Set default file
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

EXPOSE 80