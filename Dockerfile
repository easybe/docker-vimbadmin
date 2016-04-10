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

ENV INSTALL_PATH=/var/www/html/admin \
    VIMBADMIN_VERSION=3.0.12

COPY composer-config.json /root/.composer/config.json
COPY patch /patch

RUN cd /tmp \
    && rm -rf $INSTALL_PATH \
    && curl -o VIMBADMIN.tar.gz -fSL https://github.com/opensolutions/ViMbAdmin/archive/${VIMBADMIN_VERSION}.tar.gz \
    && tar zxf VIMBADMIN.tar.gz \
    && rm VIMBADMIN.tar.gz \
    && mkdir -p $INSTALL_PATH \
    && mv ViMbAdmin-${VIMBADMIN_VERSION}/* $INSTALL_PATH \
    && cd $INSTALL_PATH \
    && composer install \
    && patch $INSTALL_PATH/application/views/mailbox/email/settings.phtml < /patch \
    && rm /patch

COPY mail.mobileconfig.php $INSTALL_PATH/public/mail.mobileconfig.php
COPY mozilla-autoconfig.xml $INSTALL_PATH/public/mail/config-v1.1.xml
COPY application.ini $INSTALL_PATH/application/configs/application.ini
COPY docker-entrypoint.sh /entrypoint.sh

WORKDIR $INSTALL_PATH

ENTRYPOINT ["/entrypoint.sh"]
