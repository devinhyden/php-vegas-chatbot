# Laravel Docker
A basic docker configuration for Laravel with the following containers
- nginx
- mysql
- php
- composer
- npm
- artisan

## Usage

To get started, make sure you have [Docker installed](https://docker.com/) on your system, and then clone this repository. Add your entire Laravel project to the `src` folder, then open a terminal and from this cloned respository's root run `docker-compose up -d --build`. 

Open up your browser of choice to [http://localhost:8080](http://localhost:8080) and you should see your Laravel app running as intended. 

Containers created and their ports are as follows:

- **nginx** - `:8080`
- **mysql** - `:3306`
- **php** - `:9000`

## Install Laravel
There are multiple ways of installing Laravel; composer within container, composer on local machine, Laravel installer

###Composer container
Navigate to src and run `docker-compose run --rm composer create-project --prefer-dist laravel/laravel .`

A benefit to this setup is composer does not have to be installed locally

> This will build the container if it does not exist


### Composer on local machine
Navigate to src and run `composer create-project --prefer-dist laravel/laravel .`

### Laravel Installer
Navigate to src and run `laravel new .`

#### Install Laravel installer on local machine
`composer global require laravel/installer`
