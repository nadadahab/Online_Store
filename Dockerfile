# Base image
FROM php:7.2-apache

ENV APP_USER_NAME		online_store
ENV APP_USER_ID			1000
ENV APP_USER_HOME_DIR		/home

RUN groupadd -g ${APP_USER_ID} ${APP_USER_HOME_DIR}
RUN useradd -md ${APP_USER_HOME_DIR} -u ${APP_USER_ID} -s /bin/bash ${APP_USER_NAME} 

RUN apt-get update -y && apt-get install -y\
  openssl zip unzip git \
  libicu-dev \
  && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
  && docker-php-ext-configure intl \
  && docker-php-ext-install \
  pdo_mysql \
  && rm -rf /tmp/* \
  && rm -rf /var/list/apt/* \
  && rm -rf /var/lib/apt/lists/* \
  && apt-get clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo mbstring

WORKDIR ${APP_USER_HOME_DIR}

COPY . /home

RUN mkdir -p storage/framework/{sessions,views,cache}
RUN chmod -R 777 storage/framework
RUN chown -R www-data:www-data storage/framework


RUN composer install

CMD php artisan migrate --seed

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000