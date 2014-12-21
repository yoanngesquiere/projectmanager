sed -i -e "s/database_host:.*/database_host: $PROJECTMANAGER_DB_1_PORT_3306_TCP_ADDR/" app/config/parameters.yml
chmod -R 777 app/cache
composer install
php app/console doctrine:database:create -vvv
php app/console doctrine:schema:create -vvv
chmod -R 777 app/cache