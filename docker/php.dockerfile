FROM php:7.4-fpm

RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    curl \
    nano \
    zip \
    unzip \
    libicu-dev \
    zlib1g-dev \
    g++ \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    git \
    libxml2-dev \
    libonig-dev \
  && rm -rf /var/lib/apt/lists/*

#RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# PHP extensions
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql \
  && docker-php-ext-configure mbstring --enable-mbstring \
  && docker-php-ext-configure soap --enable-soap \
  && docker-php-ext-install \
      bcmath \
      intl \
      mbstring \
      mysqli \
      pcntl \
      pdo_mysql \
      pdo_pgsql \
      soap \
      sockets \
      zip \
&& docker-php-ext-configure gd \
  --with-jpeg=/usr/include \
  --with-freetype=/usr/include \
&& docker-php-ext-install gd \
&& docker-php-ext-install opcache \
&& docker-php-ext-enable opcache

#xdebug
ARG DEVELOPMENT
RUN if [ "${DEVELOPMENT}" = 1 ]; then \
pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo 'xdebug.remote_enable = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_handler = dbgp' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_port = 9000' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_autostart = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.remote_connect_back = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.idekey=VSCODE' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.cli_color=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.show_local_vars=1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo 'xdebug.scream=0' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
;fi

RUN cd / && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
   && php composer-setup.php --install-dir=bin --filename=composer

CMD php-fpm
