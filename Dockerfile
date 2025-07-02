FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy all project files
COPY . /var/www/html/

# Set Apache to serve from /var/www/html
# And make default page load from php/index.php
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html|' /etc/apache2/sites-available/000-default.conf \
 && echo 'DirectoryIndex php/index.php' >> /etc/apache2/apache2.conf

EXPOSE 80
