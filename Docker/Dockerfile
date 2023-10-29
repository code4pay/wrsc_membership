FROM php:7.4-apache

RUN apt-get update && apt-get install -y gnupg
RUN apt-get install -y mariadb-server libpng-dev libzip-dev npm golang-go zlib1g-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN go get github.com/mailhog/MailHog
#Apache Config
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

