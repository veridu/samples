<?php

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

// generate redirect url with appended key
$url = sprintf('https://gateway.veridu.com/1.1/widget?key=%s', $veridu['client']);

// Redirect user to the gateway
printf('<a href="%s">Gateway</a>', $url);
