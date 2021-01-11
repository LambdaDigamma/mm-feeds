![mm-feeds](https://banners.beyondco.de/mm-feeds.png?theme=dark&packageManager=composer+require&packageName=lambdadigamma%2Fmm-feeds&pattern=architect&style=style_1&description=A+package+providing+feeds+for+the+Mein+Moers+platform.&md=1&showWatermark=0&fontSize=100px&images=rss)

# Handle feeds for Mein Moers

A package providing feeds for the Mein Moers platform.

## Installation

You can install the package via composer:

```bash
composer require lambdadigamma/mm-feeds
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="LambdaDigamma\MMFeeds\MMFeedsServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="LambdaDigamma\MMFeeds\MMFeedsServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php

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

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Lennart Fischer](https://github.com/LambdaDigamma)
-   [All Contributors](../../contributors)

## License
