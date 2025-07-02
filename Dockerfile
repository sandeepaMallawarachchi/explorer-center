FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache modules
RUN a2enmod rewrite headers mime

# Copy project files
COPY . /var/www/html/

# Allow .htaccess to override settings
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf

# Set default page
RUN echo 'DirectoryIndex index.php' >> /etc/apache2/apache2.conf

EXPOSE 80
