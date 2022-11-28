# aGALA - NMR8

## About aGala

Nothing Fancy

## Installation

- clone repository
- install docker in your pc/mac
- open terminal and locate your repo directory. 
- Setup .env. Get it from slack

docker setup:
  - docker compose up -d --build php 
  - docker compose up -d --build
  
After docker image and environment is fully running. Do the following:
1. Open composer_agala cli and do
    - bash
    - composer install
2. Open npm_agala cli and do
    - bash
    - su node
    - npm install
    - npm run dev
    - npm run watch (do this if you are only working with vue or js files inside resources/js directory)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
