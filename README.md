# BileMo

[![Build Status](https://travis-ci.org/Chekaviah/bilemo.svg?branch=master)](https://travis-ci.org/Chekaviah/bilemo) 
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5834dff1593e44bb8f19381f4a46e635)](https://www.codacy.com/app/Chekaviah/bilemo?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Chekaviah/bilemo&amp;utm_campaign=Badge_Grade) 
[![Maintainability](https://api.codeclimate.com/v1/badges/d8b996235ed747a69792/maintainability)](https://codeclimate.com/github/Chekaviah/bilemo/maintainability)

BileMo is a symfony 4 project for the Openclassrooms "Application developer" path. Bilemo provide an API for resellers.

## Requirements 
- PHP >= 7.1
- MySQL >= 5.7.11
- [Composer](https://getcomposer.org/)
- [Symfony application requirements](https://symfony.com/doc/current/reference/requirements.html)

## Installation 
1. Clone the master branch
1. Install dependencies `composer install`
1. Copy the .env.dist file to .env and edit configuration for mailer and database
1. Generate the SSH keys with JWT passphrase in .env and add JWT keys path 
  ``` 
  $ mkdir var/jwt
  $ openssl genrsa -out var/jwt/private.pem -aes256 4096
  $ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem 
  ```

5. Create database `bin/console doctrine:schema:create`
5. Load data fixtures `bin/console doctrine:fixtures:load -n`
5. Run PHP's built-in Web Server `bin/console server:run`
5. Navigate to [localhost:8000](http://localhost:8000)

## Tests
1. Create tests database `bin/console doctrine:schema:create --env=test`
1. Load tests data fixtures `bin/console doctrine:fixtures:load --env=test -n`
1. Run units and functionals tests `bin/phpunit`
