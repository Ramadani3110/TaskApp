<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How To Running this App
### 1. Install All Depedency
```bash
composer install
npm install
```
### 2. Copy .env.example to .env
```bash
cp .env.example .env
```
### 3. Generate app key
```bash
php artisan key:generate
```
### 4. Change database configuration in .env
```.env
change this line
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
to
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_pass
```
### 5. Migrate all table
```bash
php artisan migrate
or with seeds
php artisan migrate --seed
```
### 6. Run Seeders (Optional)
```bash
php artisan db:seed
```
Default user from seeders
| Email          | Pass      |
|----------------|-----------|
| rama@gmail.com | R@ma12345 |
### 7. Running server
```bash
php artisan serve
npm run dev or npm run build
```
### 8. Test Api Endpoint
First open and import two json file to postmant on postmant_collection folder, in this folder have a two file, one file is postmant_collection and one more is postmant_environment file
### 9. API Endpoint
| Method |      Name     |                 URL                | Authorization |          Body (Raw)          |
|:------:|:-------------:|:----------------------------------:|---------------|:----------------------------:|
| POST   | Login         | http://127.0.0.1:8000/api/login    |       -       | name: String, email: String  |
| POST   | Logout        | http://127.0.0.1:8000/api/logout   | Bearer Token  |               -              |
| GET    | Get All Tasks | http://127.0.0.1:8000/api/my-tasks | Bearer Token  |               -              |

