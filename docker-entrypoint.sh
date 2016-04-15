#!/bin/bash -eu

MYSQL_ROOT="mysql -u root -p${DB_ENV_MYSQL_ROOT_PASSWORD} -h db"
MYSQL="mysql -u vimbadmin -p${DB_ENV_MYSQL_PASSWORD} -h db"

sed -i "s/PRIMARY_HOSTNAME/${HOSTNAME}/g"  ${INSTALL_PATH}/public/mail/config-v1.1.xml
sed -i "s/PRIMARY_HOSTNAME/${HOSTNAME}/g"  ${INSTALL_PATH}/public/mail.mobileconfig.php
sed -i "s/UUID2/$(cat /proc/sys/kernel/random/uuid)/g"  ${INSTALL_PATH}/public/mail.mobileconfig.php
sed -i "s/UUID4/$(cat /proc/sys/kernel/random/uuid)/g"  ${INSTALL_PATH}/public/mail.mobileconfig.php

echo >&2 "Setting Permissions:"
htuser='www-data'

chown -R root:${htuser} ${INSTALL_PATH}
chown -R ${htuser}:${htuser} ${INSTALL_PATH}/*

cp ${INSTALL_PATH}/public/.htaccess.dist ${INSTALL_PATH}/public/.htaccess

sed -i "s/PASSWORD/${DB_ENV_MYSQL_PASSWORD}/g" ${INSTALL_PATH}/application/configs/application.ini
sed -i "s/HOSTNAME/${HOSTNAME}/g" ${INSTALL_PATH}/application/configs/application.ini
sed -i "s/ADMIN_EMAIL/${ADMIN_EMAIL}/g" ${INSTALL_PATH}/application/configs/application.ini

cat /salts >> ${INSTALL_PATH}/application/configs/application.ini

for ((i=0;i<10;i++)); do
    if $MYSQL -e 'status' >/dev/null 2>&1; then
        exit 0
    elif $MYSQL_ROOT -e 'status' >/dev/null 2>&1; then
        if [ $($MYSQL_ROOT -N -s -e "SELECT COUNT(*) FROM information_schema.tables WHERE \
          table_schema='vimbadmin' AND table_name='domain';") -ne 1 ]; then
            echo "Creating DB and Superuser"
            $MYSQL_ROOT -e "CREATE DATABASE IF NOT EXISTS vimbadmin;"
            $MYSQL_ROOT -e "GRANT ALL ON vimbadmin.* TO 'vimbadmin'@'%' IDENTIFIED BY '"${DB_ENV_MYSQL_PASSWORD}"';"
            ./bin/doctrine2-cli.php orm:schema-tool:create
            HASH_PASS=`php -r "echo password_hash('${ADMIN_PASSWORD}', PASSWORD_DEFAULT);"`
            $MYSQL vimbadmin -e "INSERT INTO admin (username, password, super, active, created, modified) VALUES ('${ADMIN_EMAIL}', '$HASH_PASS', 1, 1, NOW(), NOW())" && \
                echo "Vimbadmin setup completed successfully"
        fi
        exit 0
    fi
    sleep 5
done
exit 1
