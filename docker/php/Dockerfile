FROM php:7.4-fpm

WORKDIR /desk/public

#RUN yes | pecl install xdebug \
#    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_enable = on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_autostart = on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.profiler_output_dir = '/app/profilers/'" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.profiler_enable_trigger = on" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY ./docker/php/config/php.ini /usr/local/etc/php/

RUN apt-get update && apt-get install -y --no-install-recommends \
        webp \
        jpegoptim \
        optipng \
        g++ \
        git \
        curl \
        python-setuptools \
        libcurl4-openssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libxml2-dev \
        libicu-dev \
        exim4 \
        libpq-dev \
        libzip-dev \
        zip \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) \
        gd \
        opcache \
        mysqli \
        pdo_mysql \
        zip \
        intl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
