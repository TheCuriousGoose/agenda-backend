```sh
composer install

cp .env.example .env

```

Change the APP_URL and Database name to the local variables 

```sh
php artisan key:generate
php artisan migrate --seed
```

Get a user email from the database

Office and Management users have the password `admin-password`
Users have the password `user-password`
