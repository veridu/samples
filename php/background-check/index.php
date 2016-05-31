<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

//Instantiate API object
$api = \Veridu\API::factory(
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
$api->user->create($veridu['username']);

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

/*
 * Sends the form data
 * More info: https://veridu.com/wiki/Personal_Resource
 */
$response = $api->personal->details();

if ($response)
	$api->personal->update($data);
else
	$api->personal->create($data);

/*
 * Creating background Check : Returns task_id as response
 *
 * @param provider (available: tracesmart)
 * @param SETUP (Dob, passport, etc.), to concatenate setups, just use the |
 *
 * To see a list of setup, please visit: https://veridu.com/wiki/TraceSmart
 */

$task_id = $api->check->create('tracesmart', Veridu\API\Check::TRACESMART_ADDRESS | Veridu\API\Check::TRACESMART_DOB);
//prints the task_id
print_r($task_id);

/*
 * Polling API to wait until check is done
 * Note: can be done via WebHook without polling
*/
do {
	usleep(500);
	$response = $api->task->details($task_id);
} while ($response['running']);

/*
 * Retrieves background check result
 * More info: https://veridu.com/wiki/Check_Resource
 */
$response = $api->check->listAll();

/*
 * Prints API response
 * More details: https://veridu.com/wiki/Check_Resource#How_to_retrieve_data_from_one_provider
*/
print_r($response);
