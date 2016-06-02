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

	/* Creates a access token under given user for facebook
	 *
	 * @param provider (facebook)
	 * @param token
	 *
	 * More info: https://veridu.com/wiki/Provider_Resource#How_to_create_a_access_token_under_given_user_for_the_given_provider
	 */
	$task_id = $api->provider->createOAuth2("facebook", $token->getAccessToken);

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

} else if ((!empty($_GET['go'])) && ($_GET['go'] === 'go')) {
	$url = $facebookService->getAuthorizationUri();
	header('Location: ' . $url);
} else {
	printf('<a href="%s?go=go">Login with Facebook!</a>', $currentUri->getRelativeUri());
}
