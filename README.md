<p align="center"><a href="https://laravel.com" target="_blank"><img src=https://digitamaze.com/static/media/logo.38073d0586cc880d8588.png width="400" alt="Digitamaze Logo"></a></p>

## About Project
Course Management System (SMK), is a management system that allows users to create courses, create users, and teachers. Vocational schools are equipped with CRUD features for each entity of teachers, students, and of course admins.

In terms of the Back-End, SMK is designed using Laravel FullStack, with Blade and Controller, and uses Laravel Sanctum for login authentication, as well as Middleware for route security.

Then for the Front-End, use several packages such as Swalfire for notifications when you want to delete (Confirmation Message). It also utilizes AlpineJS to optimize responsive UI from the sidebar to optimize it on mobile.

## How to Run

1. Clone / Fork the project.
2. Put it on your Laravel development (like: Laragon).
3. Installing dan Updating the composer.
```
composer install
composer update
```
4. Generate Key.
```
php artisan generate:key.
```
5. Configure the .env file.
6. Migrate the database
```
php artisan migrate
or
php artisan migrate:fresh
```
7. Generate the seeder file (included)
```
php artisan db:seed
```
8. Serve your Laravel.
```
php artisan serve
```


