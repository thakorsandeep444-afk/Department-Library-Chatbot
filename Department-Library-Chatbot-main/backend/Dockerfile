FROM php:8.2-apache

# Install MySQL drivers for PHP (PDO & MySQLi)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files to Apache root
COPY . /var/www/html/

EXPOSE 80