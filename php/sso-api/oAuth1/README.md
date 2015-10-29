# Single Sign On+ API Code Sample (oAuth1)
Single Sign On+ extends the regular SSO integrations with additional identity scores.
Code Sample for oAuth1 provider.

This sample uses the [PHP-SDK](https://github.com/veridu/veridu-php) to integrate the SSO+.

## Heads up!
To use this sample you need a hosted application set with Veridu.
You can do it through the [API](https://veridu.com/wiki/Application_Resource) or request it by e-mail.

## Files
 * sso-api/oAuth1/twitter-settings.php.dist: distribution settings file for Twitter application (copy this file to twitter-settings.php)
 * sso-api/oAuth1/index.php: entry point for the single sign on process

## Starting Application
Follow the instructions below to start the sample application using PHP's built-in server.
```bash
$ cd sso-api/oAuth1/
$ php -S 127.0.0.1:8080
```

On your webbrowser navigate to [http://127.0.0.1:8080/](http://127.0.0.1:8080/).

## Help!
If you have more questions, you can find more details on the following links:
 * [What do I need o do before I can call the API](https://veridu.com/wiki/What_do_I_need_to_do_before_I_can_call_the_API)
 * [How do I use the PHP SDK?](https://veridu.com/wiki/How_do_I_use_the_PHP_SDK%3F)
 * [How do I use my existing SSO Access Token to score a user?](https://veridu.com/wiki/How_do_I_use_my_existing_SSO_Access_Token_to_score_a_user%3F)
 * [SSO API EndPoint](https://veridu.com/wiki/SSO_Resource)
