<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

function getUrl() {
	 if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN)) {
		$schema = 'https';
	} else {
		$schema = 'http';
	}
	return sprintf(
		'%s://%s%s',
		$schema,
		$_SERVER['HTTP_HOST'],
		$_SERVER['REQUEST_URI']
	);
}

session_start();

if (empty($_GET['token'])) {

	$redirect = new Veridu\Gateway\Redirect($veridu['client'], $veridu['secret']);

	// retrieve current uri
	$uri = League\Uri\Schemes\Http::createFromServer($_SERVER);

	// set current url as callback url
	$redirect->setCallbackUrl((string) $uri);

	// generate redirect url with appended signature (username is optional)
	$url = $redirect->generateUrl('some-unique-user-id');

	// store redirect token id for callback validation
	$_SESSION['tokenId'] = $redirect->getTokenId();

	// Redirect user to the gateway
	printf('<a href="%s">Gateway</a>', $url);

} else {

	if (empty($_SESSION['tokenId'])) {
		die('Empty $_SESSION[\'tokenId\']!');
	}

	$callback = new Veridu\Gateway\Callback($veridu['client'], $veridu['secret']);
	$token = filter_var($_GET['token'], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_NO_ENCODE_QUOTES);

	try {
		$callback->checkCallbackSignature($token, $_SESSION['tokenId']);

		echo '<pre>', PHP_EOL;
		echo 'USERNAME: ', $callback->getUsername(), PHP_EOL;
		echo 'PASS: ', ($callback->getPass() ? 'TRUE' : 'FALSE'), PHP_EOL;
		echo '</pre>', PHP_EOL;
	} catch (Veridu\Gateway\Exception\InvalidToken $exception) {
		echo 'Invalid Token parameter.', PHP_EOL;
		echo 'Contact support.', PHP_EOL;
	} catch (Veridu\Gateway\Exception\TokenValidationFailed $exception) {
		echo 'Token validation failed.', PHP_EOL;
		echo 'Check: Issuer, Audience and Token ID values.', PHP_EOL;
	} catch (Veridu\Gateway\Exception\TokenVerificationFailed $exception) {
		echo 'Token verification failed.', PHP_EOL;
		echo 'Check: API Key and Secret values.', PHP_EOL;
	} catch (Veridu\Gateway\Exception\SubjectClaimMissing $exception) {
		echo 'Subject claim is missing.', PHP_EOL;
		echo 'Contact support.', PHP_EOL;
	} catch (Veridu\Gateway\Exception\PassClaimMissing $exception) {
		echo 'Pass claim is missing.', PHP_EOL;
		echo 'Contact support.', PHP_EOL;
	}
}
