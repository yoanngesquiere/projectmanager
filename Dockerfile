FROM eboraas/apache-php:latest

RUN apt-get update
RUN apt-get install -y curl git-core php5-mysql php5-cli php5-intl php5-curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup | bash -
RUN apt-get install -y nodejs nodejs-legacy
RUN apt-get clean

WORKDIR /var/www/
