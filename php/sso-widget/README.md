# Single Sign On+ Widget Code Sample
Single Sign On+ extends the regular SSO integrations with additional identity scores.

This sample uses the [SSO Library](https://veridu.com/wiki/SSO_Library) to integrate with the SSO+.

## Files
 * sso-widget/callback.php: handles the callback process after a single sign on is performed
 * sso-widget/composer.json: dependency list
 * sso-widget/index.php: entry point for the single sign on process
 * settings.php.dist: distribution settings file (copy this file to settings.php)

## Requirements
 * [Composer](https://getcomposer.org/): Dependency manager for PHP
 * [PHP-SDK](https://github.com/veridu/veridu-php): Veridu's PHP SDK
 * [SSO Library](https://veridu.com/wiki/SSO_Library): Veridu's SSO Library

## Installing composer
Follow the instructions bellow to install composer.
```bash
$ curl -sS https://getcomposer.org/installer | php
```

## Installing dependencies
Follow the instructions bellow to install project depencies.
```bash
$ cd sso-widget/
$ php composer.phar install
```

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd sso-widget/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need o do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I integrate my website using the SSO Library?](https://veridu.com/wiki/How_do_I_integrate_my_website_using_the_SSO_Library%3F)
 * [SSO Library](https://veridu.com/wiki/SSO_Library)
