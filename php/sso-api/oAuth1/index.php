<?php

if (!is_file(__DIR__ . '/../vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

if (!is_file(__DIR__ . '/../../settings.php'))
	die('Please copy ../../settings.php.dist to ../../settings.php');
//requiring client configuration
require_once __DIR__ . '/../../settings.php';

if (!is_file(__DIR__ . '/twitter-settings.php'))
	die('Please copy twitter-settings.php.dist to twitter-settings.php');
//requiring social app configuration
require_once __DIR__ . '/twitter-settings.php';

// token storage
$storage = new OAuth\Common\Storage\Session;

// current uri
$uriFactory = new OAuth\Common\Http\Uri\UriFactory;
$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
$currentUri->setQuery('');

// Setup the credentials for the requests
$credentials = new OAuth\Common\Consumer\Credentials(
	$twitter['key'],
	$twitter['secret'],
	$currentUri->getAbsoluteUri()
);

// Instantiate the Twitter service using the credentials, http client and storage mechanism for the token
$serviceFactory = new OAuth\ServiceFactory;
$client = new OAuth\Common\Http\Client\CurlClient;
$client->setCurlParameters(array(CURLOPT_ENCODING => ''));
$serviceFactory->setHttpClient($client);
$twitterService = $serviceFactory->createService('twitter', $credentials, $storage);

if (!empty($_GET['oauth_token'])) {
	$twitterToken = $storage->retrieveAccessToken('Twitter');

	// This was a callback request from twitter, get the token
	$token = $twitterService->requestAccessToken(
		$_GET['oauth_token'],
		$_GET['oauth_verifier'],
		$twitterToken->getRequestTokenSecret()
	);

	//Session SDK instantiation
	//more info: https://github.com/veridu/veridu-php
	$session = new Veridu\SDK\Session(
		new Veridu\SDK\API(
			new Veridu\Common\Config(
				$veridu['client'],
				$veridu['secret'],
				$veridu['version']
			),
			new Veridu\HTTPClient\CurlClient,
			new Veridu\Signature\HMAC
		)
	);
	$session->create(false);

	$api = $session->getAPI();

	$response = $api->signedFetch(
		'POST',
		'sso/twitter',
		array(
			'token' => $token->getAccessToken(),
			'secret' => $token->getAccessTokenSecret(),
			'appid' => $twitter['appid']
		)
	);

	/*
		prints API response
		for example: Array ( [status] => 1 [veridu_id] => 1 [veridu_provider] => twitter )
		more details: https://veridu.com/wiki/SSO_Resource#How_to_do_a_social_single_sign_on
	*/
	print_r($response);

	//veridu_id is the user's unique id
	$username = $response['veridu_id'];

	//retrieves user's profile
	//more info: https://veridu.com/wiki/Profile_Resource
	$response = $api->fetch('GET', "/profile/{$username}");

	/*
		prints API response
		more details: https://veridu.com/wiki/Profile_Resource#How_to_retrieve_the_consolidated_profile_of_a_given_user
	*/
	print_r($response);

} elseif ((!empty($_GET['go'])) && ($_GET['go'] === 'go')) {
	// extra request needed for oauth1 to get a request token
	$token = $twitterService->requestRequestToken();

	$url = $twitterService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
	header('Location: ' . $url);
} else {
	printf('<a href="%s?go=go">Login with Twitter!</a>', $currentUri->getRelativeUri());
}
