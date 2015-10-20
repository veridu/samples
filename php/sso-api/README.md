# Single Sign On+ API Code Sample
Single Sign On+ extends the regular SSO integrations with additional identity scores.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php) to integrate with the SSO+.

## Files
 * sso-api/composer.json: dependency list
 * sso-api/oAuth1/: oAuth1 integration sample
 * sso-api/oAuth2/: oAuth2 integration sample
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
Please refer to `oAuth1/` and `oAuth2/` folders for specific instructions.

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need o do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I use my existing SSO Access Token to score a user?](https://veridu.com/wiki/How_do_I_use_my_existing_SSO_Access_Token_to_score_a_user%3F)
 * [SSO API EndPoint](https://veridu.com/wiki/SSO_Resource)
