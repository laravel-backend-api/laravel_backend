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
RUN apk update && apk add \
    php8-pgsql \
    php8-mbstring \
    php8-xml \
    # Add other needed extensions here \
    && rm -rf /var/cache/apk/*

    
CMD ["/start.sh"]