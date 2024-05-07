# HealthCare API
HealthCare API project Laravel

This is the Laravel 9 project demo to show running my HealthCare Package.

API-EndPoint: http://localhost:8000/api/


Package built with https://github.com/modidarshan1983/Laravel-Practical-Task.git library.
Tested in Laravel 9.

Installation steps over a clean Laravel installation (v 9):

$ laravel new nameofproject

$ php artisan make:auth

change .env database laravel

$ composer require Laravel-Practical-Task/Laravel-Practical-Task:dev-master

$ composer update

$ php artisan vendor:publish

Before make this step, be sure to have your AppServiceProvider with

use Illuminate\Support\Facades\Schema; and, inside boot function: Schema::defaultStringLength(191);

$ php artisan migrate

$ php artisan db:seed --class=HealthcareSeeder
