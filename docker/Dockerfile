# Set master image
FROM php:7.2-fpm-alpine

# Install pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory permissions
COPY --chown=www-data:www-data . .


# Copy existing application directory permissions
COPY --chown=$user:$user . .

# Change current user to www
USER www-data
