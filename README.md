<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## A StackOverflow clone built with Laravel 9.x


## Installation
1- Clone the repo
```bash
https://github.com/abdelmeenam/stackoverflow-clone.git
```
2- Install dependencies
```bash
composer install
npm install
npm run build
```
3- Create a copy of your .env file
```bash
cp .env.example .env
```
4- Generate an app encryption key
```bash
php artisan key:generate
```

## Configuration
1- Open .env file and change the following:
```bash
DB_DATABASE=stackoverflow-db
DB_USERNAME=root
DB_PASSWORD=
```
2- Run php artisan migrate to migrate the database.

3- Run php artisan serve to start the development server.

4- You can now access the server at  http://localhost:8000

## Usage

## Testing

## Contributing
    
## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


