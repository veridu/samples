<?php

if (!is_file(__DIR__ . '/../vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/../vendor/autoload.php';

if (!is_file(__DIR__ . '/../../settings.php'))
	die('Please copy ../../settings.php.dist to ../../settings.php');
//requiring client configuration
require_once __DIR__ . '/../../settings.php';

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

	// Change this to your system's user id
	$username = 'unique-user-id';

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
	//assigns the fresh Veridu session to user
	//more info: https://veridu.com/wiki/User_Resource
	$session->assign($username);

	//retrieve API SDK instance from Session SDK instance
	$api = $session->getAPI();

	//sends the access token
	//more info: https://veridu.com/wiki/Provider_Resource
	$response = $api->fetch(
		'POST',
		"provider/{$username}/facebook",
		array(
			'token' => $token->getAccessToken()
		)
	);

	/*
		prints API response
		for example: Array ( [status] => 1 [task_id] => 5061 )
		more details: https://veridu.com/wiki/Provider_Resource#How_to_create_a_access_token_under_given_user_for_the_given_provider
	*/
	print_r($response);

	/*
		Pooling API to wait until data analysis is done
		Note: can be done via WebHook without pooling
	*/
	$taskId = $response['task_id'];
	do {
		usleep(500);
		$response = $api->fetch('GET', "/task/{$username}/{$taskId}");
	} while ($response['info']['running']);

	//retrieves user's profile
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
	printf('<a href="%s?go=go">Login with Facebook!</a>', $currentUri->getRelativeUri());
}
