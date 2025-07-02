FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite headers mime

# Set working directory
WORKDIR /var/www/html

# Copy all files into container
COPY . .

# Set proper Apache config to allow .htaccess overrides
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# (Optional) Set DirectoryIndex to load index.php first
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

EXPOSE 80
