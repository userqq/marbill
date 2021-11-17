FROM php:8.0-cli-buster

RUN apt-get update && apt-get upgrade -y && apt-get install -y watch
RUN docker-php-ext-install pdo pdo_mysql
RUN curl -s https://getcomposer.org/installer | php -- --filename composer --install-dir /usr/local/bin/

EXPOSE 80

CMD php -S 0.0.0.0:8000 -t /var/www/html
