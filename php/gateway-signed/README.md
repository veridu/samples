# Signed Gateway Code Sample
The most safe and flexible Gateway integration.

This sample uses the [Gateway PHP SDK](https://github.com/veridu/gateway-php) to integrate with the Gateway.

## Files
 * [gateway-unsigned/composer.json](composer.json): dependency list
 * [gateway-unsigned/index.php](index.php): entry point for the unsigned gateway process

## Requirements
 * [Composer](https://getcomposer.org/): Dependency manager for PHP
 * [Gateway PHP SDK](https://github.com/veridu/gateway-php): Veridu's Gateway PHP SDK

## Setup Steps

### Installing composer
Follow the instructions bellow to install composer.
```bash
$ curl -sS https://getcomposer.org/installer | php
```

### Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ cd gateway-signed/
$ php composer.phar install
```

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd gateway-signed/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [Veridu ID Gateway](https://veridu.com/wiki/Veridu_ID_Gateway)
