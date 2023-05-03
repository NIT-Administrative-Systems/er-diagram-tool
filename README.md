# Entity Relationship Diagram Tool for Laravel
Automatically generate interactive entity relationship diagram for models & their relationships in Laravel and emit a static HTML file for use in a VuePress site.

This package is a heavily-customized fork from [kevincobain2000/laravel-erd](https://github.com/kevincobain2000/laravel-erd) meant for use in some very specific circumstances. If you're not part of @NIT-Administrative-Systems, you should probably check out the original package instead!

## Installation
You can install the package via composer.

```bash
composer require kevincobain2000/laravel-erd --dev
```

## Usage
You can generate a static HTML file with the artisan command:

```php
php artisan erd:generate
```

This will be placed in `docs/.vuepress/public/erd`, or whatever path you have configured in `config/laravel-erd.php`.
