FROM php:7.4-fpm-alpine

RUN apk add --no-cache openssl bash mysql-client nodejs npm postgresql-dev supervisor autoconf $PHPIZE_DEPS

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini


RUN apk --no-cache add \
        libc-dev \
        freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev \
        wget \
        git \
        supervisor \
        bash \
        libzip-dev \
        libxml2-dev \
    && docker-php-ext-install \
        opcache \
        bcmath \
        pcntl \
        zip \
        soap \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer global require "hirak/prestissimo"

WORKDIR /var/www
RUN rm -rf /var/www/html

RUN ln -s public html

ADD .docker/app/supervisord/* /etc/supervisord/

COPY .docker/app/crontab /etc/crontabs/root
COPY .docker/app/php.ini /usr/local/etc/php/php.ini

COPY .docker/app/init.sh /home/init.sh
RUN sed -i -e 's/\r$//' /home/init.sh
RUN chmod +x /home/init.sh

#Permissions laravel
RUN chmod -R 775 /var/www

ENV TZ='America/Recife'

RUN apk add tzdata
RUN cp /usr/share/zoneinfo/America/Recife /etc/localtime
RUN echo "America/Recife" >  /etc/timezone

EXPOSE 9000

ENTRYPOINT ["/home/init.sh"]