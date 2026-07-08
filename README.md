# "Configurable auto-generate record number for Filament"

[![Latest Version on Packagist](https://img.shields.io/packagist/v/welman91/filament-record-number-generator.svg?style=flat-square)](https://packagist.org/packages/welman91/filament-record-number-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/welman91/filament-record-number-generator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/welman91/filament-record-number-generator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/welman91/filament-record-number-generator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/welman91/filament-record-number-generator/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/welman91/filament-record-number-generator.svg?style=flat-square)](https://packagist.org/packages/welman91/filament-record-number-generator)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require welman91/filament-record-number-generator
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file or your app's css file if using the standalone packages.

```css
@source '../../../../vendor/welman91/filament-record-number-generator/resources/**/*.blade.php';
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-record-number-generator-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-record-number-generator-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-record-number-generator-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentRecordNumberGenerator = new Welman91\FilamentRecordNumberGenerator();
echo $filamentRecordNumberGenerator->echoPhrase('Hello, Welman91!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Welman](https://github.com/welman91)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
