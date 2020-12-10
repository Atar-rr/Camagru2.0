FROM php:7.4-fpm

#RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
#
#COPY ./conf.d /usr/local/etc/php/conf.d

RUN apt-get update && apt-get install -y \
        git \
        curl \
        wget \
        vim \
        zip \
        mailutils \
        unzip \
        libonig-dev \
        libgd-dev \
        libgd3 \
        sendmail \
        libpng-dev \
        zlib1g-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && apt-get clean \
    && rm -r /var/lib/apt/lists/* \
    && pecl install xdebug-2.8.0 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install json \
    && docker-php-ext-install pdo \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install pdo_mysql

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install gd

RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" >> /usr/local/etc/php/conf.d/sendmail.ini

RUN sed -i '/#!\/bin\/sh/aservice sendmail restart' /usr/local/bin/docker-php-entrypoint
RUN sed -i '/#!\/bin\/sh/aecho "$(hostname -i)\t$(hostname) $(hostname).localhost" >> /etc/hosts' /usr/local/bin/docker-php-entrypoint

ADD ./conf.d/php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www