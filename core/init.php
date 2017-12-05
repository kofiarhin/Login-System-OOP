<?php 

	session_start();

	define('application', realpath('./'));

	$paths = array(

		application,
		application.'\classes',
		get_include_path()

	);


	set_include_path(implode(PATH_SEPARATOR, $paths));


	spl_autoload_register(function($class){

		require_once $class.".php";
	});


	$GLOBALS['config'] = array(

		'mysql' => array(
			'host' => 'localhost',
			'dbname' => 'test',
			'user' => 'root',
			'password' => ''

		),

		'session' => array(

			'session_name' => 'user',
			'token_name' => 'token'
		),

		'cookie' =>  array(

			'cookie_name' => 'hash',
			'cookie_expiry' => 604800
		)

	);


	if(cookie::exist(config::get('cookie/cookie_name')) && !session::exist(config::get('session/session_name'))) {

			$hash = cookie::get(config::get('cookie/cookie_name'));

			$hash_check = db::get_instance()->get('user_session', array('hash', '=', $hash));

			if($hash_check->count()) {

				$user = new User($hash_check->first()->user_id);

				session::put(config::get('session/session_name'), $user->data()->id);
			}
	}
