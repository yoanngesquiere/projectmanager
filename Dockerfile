FROM eboraas/apache-php:latest

RUN apt-get update
RUN apt-get install -y curl git-core php5-mysql php5-cli php5-intl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN apt-get clean

ADD . /var/www/
WORKDIR /var/www/