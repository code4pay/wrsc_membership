#!/bin/sh
cd /var/www/html
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
/etc/init.d/mariadb start
php composer.phar install

npm install
npm run development
echo "CREATE USER 'dev'@'%' IDENTIFIED BY 'password'; GRANT ALL PRIVILEGES ON *.* TO 'dev'@'%' WITH GRANT OPTION; create database laravel" |mysql
php artisan migrate:fresh
php artisan db:seed
php artisan wrsc:member --firstName First --lastName User --member_number 1 --email firstUser@test.com --password password
echo "INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES ('1', 'App\\\User', '1');"|mysql laravel
curl -L https://github.com/vrana/adminer/releases/download/v4.8.1/adminer-4.8.1-mysql.php --output public/adminer.php
chown -R www-data storage

mkdir -P /var/www/temp/mpdf
chown -R /var/www/temp