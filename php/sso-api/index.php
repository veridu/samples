<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

if (!is_file(__DIR__ . '/facebook-settings.php'))
	die('Please copy facebook-settings.php.dist to facebook-settings.php');
//requiring social app configuration
require_once __DIR__ . '/facebook-settings.php';

// token storage
$storage = new OAuth\Common\Storage\Session;

// current uri
$uriFactory = new OAuth\Common\Http\Uri\UriFactory;
$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
$currentUri->setQuery('');

// Setup the credentials for the requests
$credentials = new OAuth\Common\Consumer\Credentials(
	$facebook['key'],
	$facebook['secret'],
	$currentUri->getAbsoluteUri()
);

// Facebook's Data Access Scopes
$scopes = array(
	'public_profile', 'email', 'user_birthday', 'user_education_history',
	'user_friends', 'user_hometown', 'user_location', 'user_posts',
	'user_relationships', 'user_work_history'
);

// Instantiate the Facebook service using the credentials, http client and storage mechanism for the token
$serviceFactory = new OAuth\ServiceFactory;
$facebookService = $serviceFactory->createService('facebook', $credentials, $storage, $scopes);

if (!empty($_GET['code'])) {
	// This was a callback request from facebook, get the token
	$token = $facebookService->requestAccessToken($_GET['code']);

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

	//creates new a read/write Veridu session
	//more info: https://veridu.com/wiki/Session_Resource
	$session->create(false);

	//retrieve API SDK instance from Session SDK instance
	$api = $session->getAPI();

	//sends the access token
	//more info: https://veridu.com/wiki/SSO_Resource
	$response = $api->signedFetch(
		'POST',
		"sso/facebook",
		array(
			'token' => $token->getAccessToken()
		)
	);

	/*
		prints API response
		for example: Array ( [status] => 1 [veridu_id] => 1 [veridu_provider] => facebook )
		more details: https://veridu.com/wiki/SSO_Resource#How_to_do_a_social_single_sign_on
	*/
	print_r($response);

	//veridu_id is the user's unique id
	$username = $response['veridu_id'];

	//retrieves user profile
	//more info: https://veridu.com/wiki/Profile_Resource
	$response = $api->fetch('GET', "/profile/{$username}");

	/*
		prints API response
		more details: https://veridu.com/wiki/Profile_Resource#How_to_retrieve_the_consolidated_profile_of_a_given_user
	*/
	print_r($response);

} else if ((!empty($_GET['go'])) && ($_GET['go'] === 'go')) {
	$url = $facebookService->getAuthorizationUri();
	header('Location: ' . $url);
} else {
	$url = $currentUri->getRelativeUri() . '?go=go';
	echo "<a href='$url'>Login with Facebook!</a>";
}
