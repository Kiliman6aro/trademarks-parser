# Trademark Search Application

This application is designed for searching and analyzing trademarks. It uses parsers to extract data from web pages and caches the results to improve performance.

## Installation
1. Clone the repository: https://github.com/Kiliman6aro/trademarks-parser.git
2. Navigate to the project directory: `cd trademarks-parser`
3. Ensure you have Composer installed. If not, you can install it here. Run `comoser install`

## Configuration
Cache settings and other configurations are located in the config/app.php file. For example:

```php
return [
    'cache_lifetime' => 600, // 10 minutes
    'cache_dir' => 'runtime/cache',
];
```

## Testing
To run tests, use PHPUnit. Ensure PHPUnit is installed. If not, install it via Composer:
1. Run `composer require --dev phpunit/phpunit`
2. Run all tests: `./vendor/bin/phpunit tests`

## Run application
1. `php search.php abc`