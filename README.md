# Encrypt and Export


A Laravel package that encrypts one or more columns from a table and export them into CSV.
## Environment
This package was tested using `php 8.1` and `laravel 10.0`


## Installation

Include the repository in your `composer.json` file

```json
"repositories": [
    {
        "url": "https://github.com/mrshoikot/encrypt-and-export.git",
        "type": "git"
    }
],
```

You can install the package via composer:

```bash
composer require "mrshoikot/encrypt-and-export @dev"
```


## Usage
To export encrypted data into a CSV. You have to run

```bash
php artisan encrypt-and-export
```

A prompt will ask you from which table you want to export the data and also ask you to choose the columns you want to encrypt.
You'll also be asked the path where the exported CSV file should be stored. The default is the root directory of your project.


## Testing

```bash
composer test
```

## TODO
- [ ] Implement API usability along with CLI
- [ ] Write unit and more feature tests
- [ ] Enable and test support for older versions of PHP and Laravel

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Qurban Ali](https://github.com/mrshoikot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
