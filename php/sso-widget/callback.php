<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';


session_start();

//request nonce checking
$nonce = $_SESSION['nonce'];
if ((empty($_GET['veridu_nonce'])) || ($_GET['veridu_nonce'] !== $nonce)) {
	die('Invalid request (nonce mismatch)!');
}
//sso has failed, display error
if (empty($_GET['veridu_id'])) {
	if (empty($_GET['veridu_error'])) {
		die('Unknown error.');
	}
	die($_GET['veridu_error']);
}
// Callback signature
if (empty($_GET['veridu_sign'])) {
	die('Invalid request');
}
$parameters = array();
foreach ($_GET as $key => $value)
	if (strncmp($key, 'veridu_', 7) == 0)
		$parameters[$key] = $value;
$hash = $parameters['veridu_hash'];
$sign = $parameters['veridu_sign'];
unset($parameters['veridu_sign'], $parameters['veridu_hash']);
ksort($parameters);
if ($sign !== hash_hmac($hash, http_build_query($parameters, '', '&', PHP_QUERY_RFC1738), $config['secret'])) {
	die('Invalid signature');
}

//unique username
$username = filter_var($_GET['veridu_id'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES);

//sso provider name
$provider = filter_var($_GET['veridu_provider'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES);

//profile's name
if (empty($_GET['veridu_name']))
	$name = '';
else
	$name = filter_var($_GET['veridu_name'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES);

//profile's email
if (empty($_GET['veridu_email']))
	$email = '';
else
	$email = filter_var($_GET['veridu_email'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_NO_ENCODE_QUOTES);
