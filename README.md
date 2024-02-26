# Assessment-backend

This is backend of assessment project for laravel and Vuejs
+ Frontend and Backend are two separate projects
+ Frontend is in vue3 using composition Api and backend in laravel
+ Required Node version v19.6.0 Laravel version 10 and php version 8.2
+ Make a database in local mysql and enter credentials in .env of backend
+ In Frontend project add .env and add backend url as ```VITE_API_BASE_URL=http://127.0.0.1:8000/api```
#### Watch a video of project [demo](https://www.loom.com/share/a675fdf59fcc4987b52eacb84d97398e?sid=8fd8a0bb-ebcb-4d36-93c8-f8b1ade07f1f)

## Project Setup
Clone project add .env file and add database name and credentials

Install packages and dependencies, run migrations and seed database with test data
```sh
composer install
php artisan migrate --seed
php artisan serve
```
It will seed database with a user and some test data including feedback and comments. Credentials of user is email ```ikonic@mailinator.com``` and password is ```password```
## Working of Project
Provided successfully cloned frontend and backend as separate projects.
+ Add database name and credentials in .env of backend and backend url in .env of frontend
+ Run ``` php artisan migrate --seed```
+ It will seed database with a user and some test data including feedback and comments
+ Log into the app by using ```ikonic@mailinator.com``` and password ```password```
+ You can watch listing of feedback, view details of feedback, comment on the feedback
+ You can signup as a new user and then login to visit the project.
