## Installation

The installation is very simple and similar to traditional Laravel installation

### Install Laravel

```
composer install
```

Copy .env.example and make sure update environment variables for Fedex

```
cp .env.example .env
```

Generate Application Key

```
php artisan key:generate
```

### Install NPM dependencies

Project uses Filament and a table component from TailwindUI. So make sure to run following command to build css/js files.

```
npm install && npm run build
```

### Migration and Seed

To get started, run following command to play with test data.

_Note: This command will clean your database_

```
php artisan migrate:fresh --seed
```

It includes a seeder to add a User with email: `test@example.com` and password: `password`
and it adds a test product and fetches the rates for it.

### Open app in browser

If you are using Valet, just open the site in browser and login to Filament

Otherwise run `php artisan:serve` and visit http://127.0.0.1:8000/

### Why nothing in routes/web.php?

Well, this project uses Filament and all the routes are dynamically served.
