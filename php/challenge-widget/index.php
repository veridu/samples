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
//(can be a read-only session if only displaying the profile widget)
//more info: https://veridu.com/wiki/Session_Resource
$session->create(false);
//assigns the fresh Veridu session to target user
//more info: https://veridu.com/wiki/User_Resource
$session->assign($username);

?>
<!DOCTYPE html>
<html lang='en-us'>
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
					session: '<?=$session->getToken();?>',
					language: 'en-us',
					country: 'uk',
					version: '<?=$veridu['version'];?>'
				});
				//displaying the profile widget
				//more info: https://veridu.com/wiki/Challenge_Widget
				veridu.Widget.challenge($('#widget'), '<?=$username;?>', ['facebook','linkedin','paypal','amazon','twitter','google','instagram','yahoo','email','sms','spotafriend','cpr','nemid','personal','document']);
		</script>
	</body>
</html>
