# aGALA - NMR8

## About aGala

Nothing Fancy

## Installation

- clone repository
- docker setup:
  - docker compose up -d --build php 
  - docker compose up -d --build


## Install NPM Packages
on `npm_agala` container terminal
```shell
bash
su node
npm install
```


## Install Composer Packages
on `composer_agala` container terminal
```shell
bash
composer install
```


## Seed Database
on `php_agala` container terminal
```shell
php artisan db:seed
```



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
