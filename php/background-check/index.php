<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

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

//mimics form data
$data = array(
	'firstname' => '',
	'lastname' => '',
	'birthyear' => '',
	'birthmonth' => '',
	'birthday' => '',
	'address1' => '',
	'postcode' => ''
);

//sends the form data
//more info: https://veridu.com/wiki/Personal_Resource
$response = $api->fetch('GET', "personal/{$username}");
if ($response['state'])
	$api->fetch('PUT', "personal/{$username}", $data);
else
	$api->fetch('POST', "personal/{$username}", $data);

$response = $api->signedFetch(
	'POST',
	"check/{$username}/tracesmart",
	array(
		'setup' => 'address,dob'
	)
);

/*
	prints API response
	for example: Array ( [status] => 1 [task_id] => 5061 )
	more details: https://veridu.com/wiki/Check_Resource#How_to_create_a_new_Background_Check
*/
print_r($response);

/*
	Polling API to wait until check is done
	Note: can be done via WebHook without polling
*/
$taskId = $response['task_id'];
do {
	usleep(500);
	$response = $api->fetch('GET', "/task/{$username}/{$taskId}");
} while ($response['info']['running']);

//retrieves background check result
//more info: https://veridu.com/wiki/Check_Resource
$response = $api->signedFetch('GET', "/check/{$username}/tracesmart");

/*
	prints API response
	more details: https://veridu.com/wiki/Check_Resource#How_to_retrieve_data_from_one_provider
*/
print_r($response);
