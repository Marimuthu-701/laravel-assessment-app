<h1>Laravel News Management</h1>

<!-- ABOUT THE PROJECT -->
## About The Project
<p>This is a sample project to fetch latest news and Provide it in an API. And It has an admin panel to manage the users and news</p>

### Built With
[Laravel 10](https://laravel.com/docs/10.x)
[Filament PHP](https://filamentphp.com/docs)

## Getting Started
 
Follow the below steps to install

1. GET API key from [https://newsapi.org/](https://newsapi.org/) And that in env file
   NEWS_API_KEY=<api key>
   NEWS_API_ENDPOINT=https://newsapi.org/v2/top-headlines

2. clone the repo

3. Run `composer install`

4. Rename .env.example to .env and update the details as per you host and DB 

4. Run the command `php artisan migrate`

5. Run db seed to create a admin user `php artisan db:seed --class=UserSeeder` it will create user with follwing details
  `email: marimuthu.m@oclocksolutions.com` `Password: qwerty@2023!`
  access Admin panel with this details 'http:://yourhost.com/admin'

5. Run the command to fetch news from newsapi.org  `php artisan app:import-news`

6. To test the API to run `php artisan test'

## API 
 Here is the API documention 
  [Postman API documention](https://documenter.getpostman.com/view/27673576/2s9YRB3C9g)

  
