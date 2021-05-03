<p align="center"><h1>MatrixMultiplier - Laravel API</h1></p>



# About Matrix Multiplier

This is a laravel application to mulitply two matrices. 

It is REST API based and recives the two matrices as an array, perfomrs some required validation and return an array of characters like Excel header columns.

## Example

If you post the array below to the designated endpoint, 
```json
{
    "data" : [
        [
            [1,2,3],[4,5,6],[7,8,9]
        ],
        [
            [10,11],[12,13],[14,15]
        ]
    ]
}
```
it will return something like this

```json
[
    [
        "BX","CD"
    ],
    [
        "GB","GQ"
    ],
    [
        "KF","LD"
    ]
]
```
You are required to signup and login before you can post a request. This is managed by **Laravel Sanctum Middleware**.

# Requirements

To set it up, the following requirements need to be met:
- PHP 7.4 or PHP 8.0
- Composer
- Git


# Steps to set it up 
### **(the commands below assumes a linux environment)**

- Clone the repository
- Navigate to your local project directory
- Run composer install to get all the required laravel dependecies and packages
```bash
$ composer install
```
- Copy the .env.example file to .env 
```bash
$ cp .env.example .env
```
- Run the php artisan key generate command to Set the application key in your .env file
```bash
$ php artisan key:generate
```
- Create a database.sqlite file (or you can switch databases if you prefer)
```bash
$ touch database/database.sqlite
```
- Run php artisan migrate command to initialize the database with the relevant tables
```bash
$ php artisan migrate
```
- Run php artisan serve command to start the webserver
```bash
$ php artisan serve OR $ php artisan serve --host=0.0.0.0
```


# Using the API
### Do include the `Content-Type:application/json` and `Accept:application/json` headers in your requests from here on.
- Visit the signup endpoint (http://127.0.0.1:8000/api/signup) or whatever IP address artisan is serving on and **POST** the data in the structure below:
### `Postman` is a good choice for the following steps.
```json
{
   "name": "New User",
   "email": "user@email.com",
   "password": "secretesauce"
}
```
You will get a relevant error message or success response like this:
```json
{
    "access_token": "5|Z8nmYkUMHqCsJ2GFE8VbUM0wVpkDR1qJGeevLI2x",
    "token_type": "Bearer"
}
```

- Visit the login endpoint (http://127.0.0.1:8000/api/login) with the same credentials (assuming the previous step was successful)
```json
{
   "email": "user@email.com",
   "password": "secrete"
}
```
You will get a relevant error message or success response like this:
```json
{
    "status": "Login Success",
    "access_token": "2|b6GHoe5CdOivxjYSMmhfXdwQqhLtVkst4yFrebUR",
    "token_type": "Bearer"
}
```
- Copy the returned `access_token` from the previous step and use it as an Authorization header in the next step

- Visit the MultiplyMatrix endpoint (http://localhost:8000/api/MultiplyMatrix) and `POST` the matrices in the format below (invalid matrix format will return relevant validation messages):
### Do remember ot include the `access_token` as a `Bearer` Authorization header in this request:
`Authorization:Bearer Z8nmYkUMHqCsJ2GFE8VbUM0wVpkDR1qJGeevLI2x`

```json
{
    "data" : [
        [
            [1,2,3],[4,5,6],[7,8,9]
        ],
        [
            [10,11],[12,13],[14,15]
        ]
    ]
}
```
- A JSON response like the one below will be presendted to you.
```json
[
    [
        "BX","CD"
    ],
    [
        "GB","GQ"
    ],
    [
        "KF","LD"
    ]
]
```
- You can log out by sending a `POST` request to the logout endpoint (http://localhost:8000/api/logout). This will end your session and subsequent requests will return an "Unauthenticated" error response.

```json
{
    "message": "Unauthenticated."
}
```

## Tests

This application was developed using TDD and the tests are available in the `tests` directory. You can run `phpunit` to see the results. 

## Bugs, Comments, Questions
You can open an issue if you have questions or comments or have found some bugs in the application.
Do no hesitate to share your thoughts if you see some areas of improvement.

Thanks.
