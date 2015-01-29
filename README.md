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

# Project installation

Since it is a Symfony2 app, the requirements are the same as the Symfony's requirements 
(see [Symony2 requirements] (http://symfony.com/doc/current/reference/requirements.html))


In order to install the project manager, you need to clone the project.
```sh
git clone https://github.com/yoanngesquiere/projectmanager.git
```

Then run
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

And that's it.

If you have docker (>= 1.3) and fig, it's even simpler: just launch the startfig.sh and it launch your web brower at the ip address that is shown at the end of the script and you can see the application.
