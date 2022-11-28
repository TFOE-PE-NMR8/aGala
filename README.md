# aGALA - NMR8

## About aGala

Nothing Fancy

## Installation

- clone repository
- docker setup:
  - docker compose up -d --build php 
  - docker compose up -d --build


## Install NPM Packages
on `npm_agala` container terminal/cli
```shell
bash
su node
npm install
npm run dev
npm run watch (do this if you are only working with vue or js files inside resources/js directory)
```


## Install Composer Packages
on `composer_agala` container terminal/cli
```shell
bash
composer install
```


## Setup/update Database
on `composer_agala` container terminal/cli
```shell
bash
php artisan migrate
```


## Seed Database
on `composer_agala` container terminal/cli
```shell
bash
php artisan db:seed
```



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
