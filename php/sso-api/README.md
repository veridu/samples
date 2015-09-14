# Single Sign On+ API Code Sample
Single Sign On+ extends the regular SSO integrations with additional identity scores.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php) to integrate with the SSO+.

## Files
 * sso-api/composer.json: dependency list
 * sso-api/facebook-settings.php.dist: distribution settings file for Facebook application (copy this file to facebook-settings.php)
 * sso-api/index.php: entry point for the single sign on process
 * settings.php.dist: distribution settings file (copy this file to settings.php)

## Requirements
 * [Composer](https://getcomposer.org/): Dependency manager for PHP
 * [PHP-SDK](https://github.com/veridu/veridu-php): Veridu's PHP SDK

## Installing composer
Follow the instructions bellow to install composer.
```bash
$ curl -sS https://getcomposer.org/installer | php
```

## Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ cd sso-api/
$ php composer.phar install
```

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd sso-api/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need o do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I use my existing SSO Access Token to score a user?](https://veridu.com/wiki/How_do_I_use_my_existing_SSO_Access_Token_to_score_a_user%3F)
 * [SSO API EndPoint](https://veridu.com/wiki/SSO_Resource)
