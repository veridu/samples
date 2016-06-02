<?php

if (!is_file(__DIR__ . '/vendor/autoload.php'))
	die('Please install sample dependencies with \'composer install\'');
//using composer's autoloader
require_once __DIR__ . '/vendor/autoload.php';

if (!is_file(__DIR__ . '/../settings.php'))
	die('Please copy ../settings.php.dist to ../settings.php');
//requiring client configuration
require_once __DIR__ . '/../settings.php';

// Unique username assigned by your system
// more info: https://veridu.com/wiki/User_ID
$username = 'unique-user-id';

//Instantiate API object
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

//gets the storage object
$storage = $api->getStorage();
//gets session token
$session = $storage->getSessionToken();
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!-- Loading the jQuery Library (required by Widget Library) -->
		<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
		<!-- Loading the Widget Library (more info: https://veridu.com/wiki/Widget_Library) -->
		<script type="text/javascript" src="https://assets.veridu.com/<?=$veridu['version'];?>/sdk/veridu-widget.js"></script>
	</head>
	<body>
		<!-- Widget Container -->
		<div id="widget" style="width: 100%; height: 540px"></div>
		<script type="text/javascript">
			var //Widget instantiation
				veridu = new Veridu({
					client: '<?=$veridu['client'];?>',
					session: '<?=$session?>',
					language: 'en-us',
					country: 'uk',
					version: '<?=$veridu['version'];?>'
				});
				//displaying the profile widget
				//more info: https://veridu.com/wiki/Challenge_Widget
				veridu.Widget.challenge(
					$('#widget'),
					'<?=$username;?>',
					{
						setup: ['facebook','linkedin','paypal','amazon','twitter','google','instagram','yahoo','email','sms','spotafriend','personal','document']
					}
				);
				$(document).on('VeriduEvent', function (event, data) {
					if (data.eventname === 'UserProfile') {
						if (typeof console !== 'undefined') {
							console.log(data.user, data.profile);
						}
					}
				});
		</script>
	</body>
</html>
