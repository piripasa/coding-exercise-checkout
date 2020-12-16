## Coding Exercise: Checkout

### Language & tools

- PHP >= 7.0
- Composer (for installing dependencies)

> Class diagram: /assets/

> Unit test cases: /tests/


### Installation
This is a dockerized application. Do the following

Make sure: 
* `docker` & `docker-compose` installed in your PC.

To do:

- `cd project_directory/` into the project root directory.
- `sh start.sh` (Will do installation)
- `docker-compose run --rm composer install` for installing dependencies
- `docker-compose run --rm php vendor/bin/phpunit` for PHPUnit test
- `docker-compose run --rm php index.php` for run app
 
 ### CheckList
 
 - [x] Apply price rules to checkout process
 - [x] Scan item
 - [x] Get total

