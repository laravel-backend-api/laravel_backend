FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install required PHP extensions and dependencies
# For PostgreSQL, you will need php-pgsql
RUN apt-get update && apt-get install -y \
    php-pgsql \
    # Other extensions like php-mbstring, php-xml, etc. \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

    
CMD ["/start.sh"]