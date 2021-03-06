FROM phusion/baseimage

EXPOSE 80

# APT dependencies
RUN apt-get update && \
    apt-get -y install git \
        curl php5 php5-curl apache2 libapache2-mod-php5 php5-mysql php5-cli mysql-client \
        mysql-server && \
        apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
ENV COMPOSER_HOME /usr/bin/composer

# MySQL service
RUN mkdir /etc/service/mysql && \
    echo "#!/bin/bash"  > /etc/service/mysql/run && \
    echo "mysqld_safe" >> /etc/service/mysql/run && \
    chmod +x /etc/service/mysql/run

# Apache service
RUN mkdir /etc/service/apache2 && \
    echo "#!/bin/bash"  > /etc/service/apache2/run && \
    echo "exec apache2ctl -DNO_DETACH" >> /etc/service/apache2/run && \
    chmod +x /etc/service/apache2/run

# Copy ProjectManager sources
WORKDIR /var/www/html/
ADD . /var/www/html

RUN mkdir -p /etc/my_init.d
ADD docker/baseimage/includes/docker_setup.sh /etc/my_init.d/docker_setup.sh
RUN chmod +x /etc/my_init.d/docker_setup.sh

RUN sed -i -e 's?/var/www/html?/var/www/html/web?' /etc/apache2/sites-enabled/000-default.conf

VOLUME ["/var/www/html"]
