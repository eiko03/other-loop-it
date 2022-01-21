## Simple Laravel Api

To Setup project

- clone the project
- composer install
- create database
- php artisan:migrate
- php artisan passport:install
- php artisan serve

To run tests

- add test_db.sqlite in database folder
- add DB_TEST_DATABASE=./database/test_db.sqlite in .env
- run ./vendor/bin/phpunit --testdox

To reset database and dummy data for testing run below command
- php artisan test:prepare

Default data includes dummy cars, makes, models and a user. Its credentials is shown below

email:      user@example.test
password:   password
 
It runs \App\Console\Commands\TestPrepare::class command
