FROM fedora:28

Maintainer Aaron Tolentino <aarontolentino123@gmail.com>

RUN dnf -y update && dnf clean all
RUN dnf -y install procps 
RUN dnf -y install vim wget man git composer

RUN dnf -y install php
RUN dnf -y install php-pecl-apcu php-cli php-pear php-pdo php-mysqlnd php-pgsql php-pecl-mongodb php-pecl-memcache php-pecl-memcached php-gd php-mbstring php-mcrypt php-xml php-bcmath

RUN dnf -y install nginx && dnf clean all
RUN echo "nginx on Fedora" > /usr/share/nginx/html/index.html

RUN dnf -y install phpmyadmin

RUN mkdir /run/php-fpm
RUN echo "alias ll='ls -alF'" >> /etc/bashrc

ADD ./site.conf /etc/nginx/conf.d/
RUN mv /etc/nginx/nginx.conf /etc/nginx/nginx.conf.orig
ADD ./nginx.conf /etc/nginx/

ENTRYPOINT ["/bin/bash"]