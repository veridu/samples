# Challenge API Code Sample
Identity Challenge during a verification process.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php) to create a challenge process.

## Files
 * [challenge-api/composer.json](composer.json): dependency list
 * [challenge-api/oAuth1/](oAuth1/): oAuth1 integration sample
 * [challenge-api/oAuth2/](oAuth2/): oAuth2 integration sample
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
$ cd challenge-api/
$ php composer.phar install
```

## Starting Application
Please refer to [oAuth1/](oAuth1/) and [oAuth2/](oAuth2/) folders for specific instructions.

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need to do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I retrieve a user's Verified Profile?](https://veridu.com/wiki/How_do_I_retrieve_a_user%27s_Verified_Profile%3F)
 * [Provider API EndPoint](https://veridu.com/wiki/Provider_Resource)
 * [Task API EndPoint](https://veridu.com/wiki/Task_Resource)
