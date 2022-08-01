# Sortileges' API

Live app https://sortileges-api.herokuapp.com/

## Setup

Install packages

`composer install`

Prepare database

`docker-compose up -d`

`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

Prepare test database

`php bin/console --env=test doctrine:database:create`

`php bin/console --env=test doctrine:schema:create`

## Usage

Run server

`composer start`

Run tests

`composer test`
