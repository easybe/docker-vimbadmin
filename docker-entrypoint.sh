#!/bin/bash -eux

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

for ((i=0;i<10;i++))
do
    DB_CONNECTABLE=$(mysql -uvimbadmin -p${DB_ENV_MYSQL_PASSWORD} -hdb -P3306 -e 'status' >/dev/null 2>&1; echo "$?")
    if [[ DB_CONNECTABLE -eq 0 ]]; then
      if [ $(mysql -N -s -uvimbadmin -p${DB_ENV_MYSQL_PASSWORD} -hdb -e \
        "select count(*) from information_schema.tables where \
          table_schema='vimbadmin' and table_name='domain';") -ne 1 ]; then
        echo "Creating DB and Superuser"
        HASH_PASS=`php -r "echo password_hash('${ADMIN_PASSWORD}', PASSWORD_DEFAULT);"`
        ./bin/doctrine2-cli.php orm:schema-tool:create
        mysql -u vimbadmin -p${DB_ENV_MYSQL_PASSWORD} -h db vimbadmin -e \
          "INSERT INTO admin (username, password, super, active, created, modified) VALUES ('${ADMIN_EMAIL}', '$HASH_PASS', 1, 1, NOW(), NOW())" && \
        echo "Vimbadmin setup completed successfully"
      fi
    fi
    sleep 5
done
exit 1
