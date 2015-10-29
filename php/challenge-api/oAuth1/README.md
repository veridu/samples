# Challenge API Code Sample (oAuth1)
Challenge an identity during a verification process using an oAuth1 provider.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php) to integrate the Challenge.

## Heads up!
To use this sample you need a hosted application set with Veridu.
You can do it through the [API](https://veridu.com/wiki/Application_Resource) or request it by e-mail.

## Files
 * challenge-api/oAuth1/twitter-settings.php.dist: distribution settings file for Twitter application (copy this file to challenge-api/twitter-settings.php)
 * challenge-api/oAuth1/index.php: entry point for the challenge process

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd challenge-api/oAuth1/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need o do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I retrieve a user's Verified Profile?](https://veridu.com/wiki/How_do_I_retrieve_a_user%27s_Verified_Profile%3F)
 * [Provider API EndPoint](https://veridu.com/wiki/Provider_Resource)
 * [Task API EndPoint](https://veridu.com/wiki/Task_Resource)
