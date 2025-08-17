FROM yiisoftware/yii2-php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Use php.ini-production as the base
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Install additional dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql
