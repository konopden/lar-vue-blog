# Laravel/Vue.js blog

## Features
- Laravel 6
- Vue.js + VueRouter + Vuex + VueI18n
- SPA admin panel for CRUD operations with data.
- Login, register, email verification and password reset
- Bootstrap 4 + Font Awesome 5

## Screenshots
Admin panel
![alt text](screens/admin_panel.png?raw=true "Admin panel view")

Main page
![alt text](screens/main_page.png?raw=true "Main page")

## Requirement
- PHP >= 7.2.18
- Node.js >= 8.9.0

## Installation
- git clone git@github.com:konopden/lar-vue-blog
- composer update

**OR**
- composer create-project konopden/lar-vue-blog .


- npm init
- Customize .env file, set your database connection.
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan admin:create

## Tests
```
vendor\bin\phpunit

# //laravel.com/docs/7.x/dusk
php artisan dusk:install
php artisan dusk
```

## Usage

#### Development

```bash
# build and watch
npm run watch

# serve with hot reloading
npm run hot
```

#### Production

```bash
npm run production
```
