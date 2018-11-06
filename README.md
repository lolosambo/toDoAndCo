ToDoListApp
========

In order to install the ToDoListApp Project, you have to follow these indications : 

## Prepare your environment

- First, you need to install git, Composer and Docker

Follow the steps for Git Installation here : https://git-scm.com/downloads

For Composer here : https://getcomposer.org/download/

And for Docker (for Mac, but Windows Installation is not far away :)) here : https://docs.docker.com/docker-for-mac/

- Now your're ready to use git. It's time to init project : to do this, go to your working directory and use this command :

```
git init
```

Copy and paste the following line on your terminal (or console) :
```
git clone https://github.com/lolosambo/toDoAndCo.git
```

## Define your Environment Variables

Simply, turn the `app/config/parameters.yml.dist` into `parameters.yml` and change each variable value as you wish.

## Install your docker environment

Your Dockerfile, docker-compose.yaml files and all the base configuration are ready to use. All you have to do is write :
```
docker-compose build
docker-compose up -d
```

## Composer to the rescue !

Install all dependencies with composer with these lines :
```
make composer-install
make autoload
```

A `Makefile` gives you a lot of shortcuts for Symfony, Composer, Doctrine, PhpUnit and BlackFire most used commands

## Configure your database and make fixtures

First create your database
```
make create-database
make schema-update
```

ToDoListApp project give to you the ability to invoke Fixtures very simply
```
make fixtures
```
Your project is ready to use !! Enjoy !
