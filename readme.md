# Linkify

Linkify is an intuitive and comprehensive link shortener service made with Laravel 5.6 and PHP 7.1

# Features

  - User account management
  - Link usage, tracking, and analytics
  - More soon!

# Installation

### Requisites
- PHP 7.x+
- MySQL
- Laravel 5.6+
- Composer
- Homebrew

Install PHP 7.1 with Homebrew

```sh
$ brew update
$ brew install php71
```

Install Composer with Homebrew

```sh
$ brew update
$ brew install composer
$ composer -V
```

**NOTE: You must have MySQL running at this point.**
- [MAMP](https://www.mamp.info/en/) (Recommended)
- [XAMPP](https://www.apachefriends.org/index.html)


Install source and start server

```sh
$ git clone https://github.com/xseano/Linkify.git
$ cd Linkify
$ composer install
$ php artisan serve
```

### Database Setup
- Make sure you have an empty database ready to be formatted
- Ensure all database credentials and information are correct in the .env file

```sh
$ php artisan migrate
```

License
----

See [MIT](https://github.com/xseano/Linkify/blob/master/LICENSE)

