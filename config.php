<?php
	define('TRIPL_CLIENT_ID',		'ENTER_CLIENT_ID_HERE');
	define('TRIPL_CLIENT_SECRET',	'ENTER_CLIENT_SECRET_HERE');
	define('TRIPL_API_BASE',		'http://tripl.com/api/v1/');

	function __autoload( $class ){
		require_once( lcfirst($class) . ".php" );
	}