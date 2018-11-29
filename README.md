# GMO Payment Geteway - Bank Transfer

## Installation

Require this package with composer. It is recommended to only require the package for development

```shell
composer require hoavq/gmo-pg-bank-transfer
```

If you don't use auto-discovery, add the ServiceProvider to the `providers` array in config/app.php

```php
\HoaVQ\GmoPG\GmoServiceProvider::class,
```

add this to your facades in app.php:

```php
'GMO' => \HoaVQ\GmoPG\GmoFacade::class,
```
## Publish config and lang resource
Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="HoaVQ\GmoPG\GmoServiceProvider"
```

## Usage
```php
$result = \GMO::accountSearch([
    'Bank_ID' => '99992',
]);
// or 
$result = \GMO::AccountSearch([
    'Bank_ID' => '99992',
]);
// =========================
$result = \GMO::depositSearch([
    'Deposit_ID' => 'ABC8888',
]);
// or

$result = \GMO::DepositSearch([
    'Deposit_ID' => 'ABC8888',
]);
```
