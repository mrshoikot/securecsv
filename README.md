# securecsv


A Laravel package that encrypts one or more columns from a table and export them into CSV.
## Environment
This package was tested using `php 8.1` and `laravel 10.0`


## Installation

You can install the package via composer:

```bash
composer require mrshoikot/securecsv:dev-main"
```


## Usage

```php
use Mrshoikot\EncryptAndExport\EncryptAndExport;

$exporter = new EncryptAndExport();
$exporter->setTable('TABLE_NAME');
$exporter->selectColumn('COLUMN_NAME');
$exporter->setPath(storage_path('exports')); // Default is /storage/app
$exporter->export();
```

The `selectColumn()` method also accepts array of column names.

To use the package from command line. You have to run

```bash
php artisan securecsv
```

A prompt will ask you from which table you want to export the data and also ask you to choose the columns you want to encrypt.
You'll also be asked the path where the exported CSV file should be stored. The default is the root directory of your project.


## Testing

```bash
composer test
```

## TODO
- [x] <del>Implement API usability along with CLI</del>
- [x] <del>Write unit and more feature tests</del>
- [ ] Enable and test support for older versions of PHP and Laravel
- [ ] Include option for having CSV header
- [ ] Add ability for selecting multiple column at once

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
