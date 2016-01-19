FROM debian:jessie

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        bzip2 \
        sudo \
        git \
        ca-certificates \
        curl \
        mysql-client \
        patch \
        php5-cli \
        php5-memcache \
        php5-mysql \
    && rm -rf /var/lib/apt/lists/* \
    && curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin

ENV INSTALL_PATH=/var/www/html \
    VIMBADMIN_VERSION=3.0.12

COPY patch /patch

RUN cd /tmp \
    && rm -rf $INSTALL_PATH \
    && curl -o VIMBADMIN.tar.gz -fSL https://github.com/opensolutions/ViMbAdmin/archive/${VIMBADMIN_VERSION}.tar.gz \
    && tar zxf VIMBADMIN.tar.gz \
    && rm VIMBADMIN.tar.gz \
    && mv ViMbAdmin-${VIMBADMIN_VERSION} $INSTALL_PATH \
    && cd $INSTALL_PATH \
    && composer install \
    && patch $INSTALL_PATH/application/views/mailbox/email/settings.phtml < /patch \
    && rm /patch

WORKDIR /var/www/html
VOLUME /var/www/html
COPY mail.mobileconfig.php /var/www/html/public/mail.mobileconfig.php
COPY mozilla-autoconfig.xml /var/www/html/public/mail/config-v1.1.xml
COPY docker-entrypoint.sh /entrypoint.sh
COPY application.ini /var/www/html/application/configs/application.ini

ENTRYPOINT ["/entrypoint.sh"]
