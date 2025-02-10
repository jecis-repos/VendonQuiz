FROM php:8.2.0RC1-fpm-bullseye

# Set working directory
RUN mkdir -p /var/www

# RUN adduser --disabled-password --gecos ''  www
# RUN chown -R www:www /var/www
# RUN chmod -R 777 /var/www
# RUN usermod -u 1000 www
# USER www
WORKDIR /var/www

# Install dependencies
USER root
RUN  apt-get update  \
    && apt-get install -y --no-install-recommends \
			git \
			zip \
			fish \
			unzip \
			libzip-dev \
			libpng-dev \
			libjpeg62-turbo-dev \
			libfreetype6-dev \
			libwebp-dev \
			libonig-dev \
			libxml2-dev \
			libpq-dev \
			libssl-dev \
			libcurl4-openssl-dev \
			libicu-dev \
			libxslt-dev \
			libzip-dev \
			wget \
			cron \
			curl \
			sendmail \
			&& docker-php-ext-install -j$(nproc) \
			pdo \
			pdo_mysql \
			gd \
			mbstring \
			exif \
			pcntl \
			bcmath \
			soap \
			intl \
			xsl \
			zip \
			opcache \
			sockets \
     		mysqli \
			&& pecl install redis xdebug \
			&& docker-php-ext-enable redis xdebug \
			&& docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
			&& docker-php-ext-install -j$(nproc) gd \
			&& apt-get clean && rm -rf /var/lib/apt/lists/*
# Install PHP xdebug

# USER www
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

