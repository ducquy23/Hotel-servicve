# -------------------------------
#  Base image: PHP 8.1 FPM
# -------------------------------
FROM php:8.1-fpm

# -------------------------------
#  Install system dependencies
# -------------------------------
RUN apt-get update && apt-get install -y \
    build-essential \
    zlib1g-dev \
    default-mysql-client \
    curl \
    gnupg \
    procps \
    cron \
    supervisor \
    vim \
    git \
    unzip \
    locales \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libicu-dev \
    libxml2-dev \
    libcurl4-openssl-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install \
        zip \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        gd \
        exif \
        curl \
        xml \
        mbstring \
        intl \
        bcmath && \
    ln -sf /usr/share/zoneinfo/Asia/Ho_Chi_Minh /etc/localtime && \
    echo "Asia/Ho_Chi_Minh" > /etc/timezone && \
    rm -rf /var/lib/apt/lists/*

# -------------------------------
#  Set environment variables
# -------------------------------
ENV LANG=en_US.UTF-8 \
    LC_ALL=en_US.UTF-8 \
    LANGUAGE=en_US:en \
    TZ=Asia/Ho_Chi_Minh

# -------------------------------
#  Install Composer
# -------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------------
#  Install Node.js 20 (LTS)
# -------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# -------------------------------
#  Setup working directory
# -------------------------------
WORKDIR /var/www/html

# -------------------------------
#  Copy Composer files and install dependencies
# -------------------------------
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts --prefer-dist

# -------------------------------
#  Copy source code
# -------------------------------
COPY . .

# -------------------------------
#  Set permissions
# -------------------------------
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html && \
    mkdir -p \
      /var/www/html/fuel/app/cache \
      /var/www/html/fuel/app/logs \
      /var/www/html/fuel/app/tmp \
      /var/www/html/public/uploads && \
    chmod -R 777 \
      /var/www/html/fuel/app/cache \
      /var/www/html/fuel/app/logs \
      /var/www/html/fuel/app/tmp \
      /var/www/html/public/uploads

# -------------------------------
#  Copy PHP config files
# -------------------------------
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# -------------------------------
#  Expose port and health check
# -------------------------------
EXPOSE 9000
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm -t || exit 1

# -------------------------------
#  Start PHP-FPM
# -------------------------------
CMD ["php-fpm"]
