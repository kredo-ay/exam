FROM devilbox/php-fpm-8.0:latest

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN set -e; \
    apt-get update && \
    apt-get install -qqy --no-install-recommends \
    curl wget supervisor zip unzip nano gnupg2 software-properties-common && \
    rm -rf /var/lib/apt/lists;

RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN set -e; \
    apt-get update && \
    apt-get install -qqy \
    nodejs && \
    rm -rf /var/lib/apt/lists; 

RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN docker-php-ext-install pdo_mysql
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www
COPY --chown=www:www . /var/www

USER www

EXPOSE 9000

CMD ["php-fpm"]
