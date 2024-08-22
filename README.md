```sh
composer install

cp .env.example .env

```

Change the APP_URL and Database name to the local variables 

```sh
php artisan key:generate
php artisan migrate --seed
````

