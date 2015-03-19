Installation Guide
==================

# Classic project installation

Project manager is a Symfony2 app, so the requirements are the same as the Symfony's requirements 
(see [Symony2 requirements] (http://symfony.com/doc/current/reference/requirements.html))


In order to install the project manager, you need to clone the project.
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

If you have docker (>= 1.3) and fig, it's even simpler: just launch ``` ./start-in-docker.sh```, wait during the installation,
then open your web browser at the ip address that is shown at the end of the script execution so you can see the application.
