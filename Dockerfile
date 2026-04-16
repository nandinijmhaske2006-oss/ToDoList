FROM php:8.1-apache

# Install mysqli
RUN docker-php-ext-install mysqli

# Copy project files
COPY . /var/www/html/

# Give permissions
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80
