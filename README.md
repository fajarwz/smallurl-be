# SmallUrl-BE

A backend of simple url shortener app. Built with Laravel.

## Installation

**Step 1:** Duplicate `.env.example` and rename it to `.env`

**Step 2:** Run

```
php artisan key:generate
```

**Step 3:** Adjust the database setting with your own's environment

**Step 4:** Run 

```
composer install
```

**Step 5:** Set the jwt-auth, generate the secret key 

```
php artisan jwt:secret
```

**Step 6:** To generate api documentation, run

```
php artisan l5:generate
```

## Testing

Run

```
php artisan test
```

## Frontend

[SmallUrl FE](https://github.com/fajarwz/smallurl-fe)

## Demo

Hosted on Heroku: [SmallURL](https://smallurl-fajarwz.herokuapp.com/api/documentation)