# Challenge Widget Code Sample
Identity Challenge during a verification process.

This sample uses the [Widget Library](https://veridu.com/wiki/Widget_Library) to create a challenge process.

## Files
 * [challenge-widget/composer.json](composer.json): dependency list
 * [challenge-widget/index.php](index.php): entry point for the challenge process
 * [settings.php.dist](../settings.php.dist): distribution settings file (copy this file to settings.php)

## Requirements
 * [Composer](https://getcomposer.org/): Dependency manager for PHP
 * [PHP-SDK](https://github.com/veridu/veridu-php-1.0): Veridu's PHP SDK
 * [Widget Library](https://veridu.com/wiki/Widget_Library): Veridu's Widget Library

## Setup Steps

### Installing composer
Follow the instructions bellow to install composer.
```bash
$ curl -sS https://getcomposer.org/installer | php
```

### Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ cd challenge-widget/
$ php composer.phar install
```

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd challenge-widget/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need to do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I retrieve a user's Verified Profile?](https://veridu.com/wiki/How_do_I_retrieve_a_user%27s_Verified_Profile%3F)
 * [How do I display the verification widget?](https://veridu.com/wiki/How_do_I_display_the_verification_widget%3F)
 * [Widget Library](https://veridu.com/wiki/Widget_Library)
