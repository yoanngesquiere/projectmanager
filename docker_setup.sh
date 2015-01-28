#!/bin/bash
echo "Symfony Installation : Start"
# Get the container address at startup
sed -i -e "s/database_host:.*/database_host: $PROJECTMANAGER_DB_1_PORT_3306_TCP_ADDR/" app/config/parameters.yml
# Clear cache avoiding permission problems in the new container
rm -rf app/cache
# Classic symfony install
composer install
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:create
# Container is with root user, application with www-data
chmod -R 777 app/cache
echo "Symfony Installation : End"

# Install FrontEnd dependencies
echo "FrontEnd dependencies Installation : Start"
npm install
echo "FrontEnd dependencies Installation : End"

echo "Installation Complete"