projectmanager
==============

[![Build Status](https://travis-ci.org/yoanngesquiere/projectmanager.svg?branch=master)](https://travis-ci.org/yoanngesquiere/projectmanager)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/aac62688-139c-4b28-bab7-a1e42e623b40/mini.png)](https://insight.sensiolabs.com/projects/aac62688-139c-4b28-bab7-a1e42e623b40)
[![Code Climate](https://codeclimate.com/github/yoanngesquiere/projectmanager/badges/gpa.svg)](https://codeclimate.com/github/yoanngesquiere/projectmanager)


The project manager is a website created to manage plannings for teams.

Currently, it allows to :
- Manage users
- Manage teams
- Manage projects
- Manage projects' tasks

# Classic project installation

Since it is a Symfony2 app, the requirements are the same as the Symfony's requirements 
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

In order to install the front-end dependencies, you need to have npm. And to generate the assets for Symfony, you need gulp.
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

And that's it. Project Manager is now installed

# Docker project installation

If you have docker (>= 1.3) and fig, it's even simpler: just launch the ```sh startfig.sh```, wait during the installation, then open your web browser at the ip address that is shown at the end of the script execution so you can see the application.
