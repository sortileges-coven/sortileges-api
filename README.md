# Sortileges' API

## Setup

Install packages

`composer install`

Prepare database

`docker-compose up -d`

`php bin/console doctrine:database:create`

`php bin/console doctrine:migrations:migrate`

## Usage

Run server

`symfony server:start`
