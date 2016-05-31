# Background Check API Code Sample
Traditional Background Check based on Credit data.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php-1.0) to integrate the background-check.

## Files
 * [background-check/composer.json](composer.json): dependency list
 * [background-check/index.php](index.php): entry point for the background-check process
 * [settings.php.dist](../settings.php.dist): distribution settings file (copy this file to settings.php)

## Requirements
 * [Composer](https://getcomposer.org/): Dependency manager for PHP
 * [PHP-SDK](https://github.com/veridu/veridu-php): Veridu's PHP SDK

## Setup Steps

### Installing composer
Follow the instructions bellow to install composer.
```bash
$ curl -sS https://getcomposer.org/installer | php
```

### Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ cd background-check/
$ php composer.phar install
```

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd background-check/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need to do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I create a Background Check?](https://veridu.com/wiki/How_do_I_create_a_Background_Check%3F)
 * [Check API EndPoint](https://veridu.com/wiki/Check_Resource)
