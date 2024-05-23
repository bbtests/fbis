FBIS  TEST

# EASY SETUP

Clone the repository `git clone https://github.com/bbtests/fbis`

## Open the project directory in terminal

rename .env.example to  .env and update the  details:
     `cp .env.example .env`

### Using Sail(for docker)

#### Prequisite: php8.2+ and composer

Install packages and run:
    `composer install && ./vendor/bin/sail up -d`

### Using docker

run:
    `docker compose up -d`

### Getting Started

run migration & seeding  default configuration(It should be run only once)
    `php artisan migrate:fresh --seed && php artisan key:generate`

# API Documentation

import `postman_collection.json` into postman to see the API documentation

for `BAP_API_*` values, check `https://documenter.getpostman.com/view/25151909/2sA3JKc29C`
for `SHAGO_API_*` values, check `https://documenter.getpostman.com/view/19961344/2sA3JKc1qV`
