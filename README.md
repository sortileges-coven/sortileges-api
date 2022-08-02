# Sortileges' API

Live app https://sortileges-api.herokuapp.com/

## Setup

Install packages

`composer install`

Generate auth keys using 'sortileges' as a passphrase

`php bin/console lexik:jwt:generate-keypair`

Or if it's not working

`mkdir -p config/jwt`
`openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096`
`openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout`

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
