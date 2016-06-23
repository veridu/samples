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

// Instantiate the twitter service using the credentials, http client and storage mechanism for the token
$serviceFactory = new OAuth\ServiceFactory;
$client = new \OAuth\Common\Http\Client\CurlClient;
$client->setCurlParameters(array(\CURLOPT_ENCODING => ''));
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

	// Unique username assigned by your system
	// more info: https://veridu.com/wiki/User_ID
	$username = 'unique-user-id';


	//Instantiates the API object
	$api = Veridu\API::factory(
		$veridu['client'],
		$veridu['secret'],
		$veridu['version']
	);

	/*
	 * Creates new a read/write Veridu session
	 * More info: https://veridu.com/wiki/Session_Resource
	 */
	$api->session->create(false);

	/*
	 * Assigns the new user to the current session
	 * More info: https://veridu.com/wiki/User_Resource#How_to_create_a_new_user_entry_and_assign_it_to_the_current_session
	 */
	$api->user->create($username);

	/*
	 * Creates a access token under given user for twitter
	 *
	 * @param provider (twitter)
	 * @param token
	 * @param secret
	 * @param appid (not necessary)
	 * More info: https://veridu.com/wiki/Provider_Resource#How_to_create_a_access_token_under_given_user_for_the_given_provider
	*/
	$task_id = $api->provider->createOAuth1(
		'twitter',
		$token->getAccessToken(),
		$token->getAccessTokenSecret(),
		$twitter['appid']
	);

	//prints task_id
	print_r($task_id);

	/*
	 * Polling API to wait until data analysis is done
	 * Note: can be done via WebHook without polling
	*/
	do {
		usleep(500);
		$response = $api->task->details($task_id);
	} while ($response['info']['running']);

	/*
	 * Retrieves user's profile
	 * More info: https://veridu.com/wiki/Profile_Resource#How_to_retrieve_the_consolidated_profile_of_a_given_user
	 */
	$response = $api->profile->retrieve();

	//prints api response
	print_r($response);

} elseif ((!empty($_GET['go'])) && ($_GET['go'] === 'go')) {
	// extra request needed for oauth1 to get a request token
	$token = $twitterService->requestRequestToken();

	$url = $twitterService->getAuthorizationUri(array('oauth_token' => $token->getRequestToken()));
	header('Location: ' . $url);
} else {
	printf('<a href="%s?go=go">Login with Twitter!</a>', $currentUri->getRelativeUri());
}
