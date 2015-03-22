Installation Guide
==================

# Classic project installation

Project manager is a Symfony2 app, so the requirements are the same as the Symfony's requirements 
(see [Symony2 requirements] (http://symfony.com/doc/current/reference/requirements.html))


In order to install the Project manager, you need to clone the project.
```sh
git clone https://github.com/yoanngesquiere/projectmanager.git
```

You also need to have [composer] (https://getcomposer.org/download/) installed.

Then run:
```sh
cd projectmanager
composer install
```

Project manager requires a database connection. You can configure it by updating the parameters.yml file.
Then, run :
```sh
php app/console doctrine:database:create
php app/console doctrine:schema:create
```

# Working on the front-end part

In order to install the front-end dependencies, you need to have npm.
And to generate the assets for Symfony, you need gulp.  
Make sure you have [NodeJs / NPM] (https://docs.npmjs.com/getting-started/installing-node) installed.

To install gulp and the project dependencies, run:
```sh
npm install
npm install -g gulp
```

To generate the front-end assets, run:
```sh
gulp
```

And that's it. Project Manager is now installed.

# Docker project installation

If you have docker (>= 1.3), you can use it to run the Project manager.  
The script ``` ./start-in-docker.sh``` does all it needs to build and run the images and the containers.  
If you want to use a single image that is not linked to your filesystem, run ``` ./start-in-docker.sh baseimage```.  
If you want to use docker-compose to have two separate images linked to your filesystem (really convenient to develop),
run ``` ./start-in-docker.sh compose```.  
In the two cases, you will have to wait during the installation. At the end, an IP address it shown.
You can paste it into your browser and start using the Project manager.

