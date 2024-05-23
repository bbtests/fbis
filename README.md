# FBIS  TEST

## EASY SETUP

Clone the repository `git clone https://github.com/bbtests/fbis`

### Open the project directory in terminal

copy .env.example to  .env and update the  details:
     `cp .env.example .env`

#### Using Sail (docker), php8.2+ and composer required

Install packages and run:
    `composer install && ./vendor/bin/sail up -d`

#### Using Docker

run:
    `docker compose up -d`

#### Getting Started

run migration & seeding default configuration in the app container terminal (Only once)
    `php artisan migrate:fresh --seed && php artisan key:generate`

## API Documentation

import `postman_collection.json` into postman to see the API documentation

for `BAP_API_*` values, check `https://documenter.getpostman.com/view/25151909/2sA3JKc29C`
for `SHAGO_API_*` values, check `https://documenter.getpostman.com/view/19961344/2sA3JKc1qV`
