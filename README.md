## Technologies used:
* PHP 8.1
* Laravel 10
* JQuery

**Before installation, make sure you have composer installed on your system by typing in terminal: `composer`**

*If you don't have composer, you can download it from: https://getcomposer.org/download/*

## Project installation (Ubuntu)
Firstly, open your terminal and perform the following steps to run the application

1. Run `git clone https://github.com/JosephDeFacto/vlc.git`
1. Navigate to your root project directory
1. Install composer by running: `composer install`
1. Start your app by running: `php artisan serve`
   - If everything works, you'll get something like this: Server running on [http://127.0.0.1:8001].

## Usage
### HTTP Request (valid search query)
> GET `search?q=name`

> Example: `http://127.0.0.1:8000/search?q=deadwood`

### HTTP Response
> Status code by default is 200

> result: Deadwood

### HTTP Request (valid search query with no results)
> GET `search?q=nonexistsentname`

> Example: `http://127.0.0.1:8000/search?q=gal`

### HTTP Response
> Status Code: 404

> Message: No results found.

### HTTP Request (missing or empty search query)
> GET `search?q=""`

> Example: `http://127.0.0.1:8000/search?q=""`

### HTTP Response
> Status Code: 400 

> Message: Your input field is empty.
