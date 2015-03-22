FROM eboraas/apache-php:latest

RUN apt-get update
RUN apt-get install -y curl git-core php5-mysql php5-cli php5-intl
RUN apt-get update
RUN apt-get install -y php5-curl wget xvfb

# Install firefox on debian...
RUN apt-get remove iceweasel
RUN echo "\ndeb http://downloads.sourceforge.net/project/ubuntuzilla/mozilla/apt all main" | tee -a /etc/apt/sources.list > /dev/null
RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv-keys C1289A29
RUN apt-get update
RUN apt-get install -y firefox-mozilla-build

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup | bash -
RUN apt-get install -y nodejs nodejs-legacy
RUN apt-get install -y openjdk-7-jre
RUN wget http://selenium-release.storage.googleapis.com/2.45/selenium-server-standalone-2.45.0.jar

RUN apt-get clean

WORKDIR /var/www/
