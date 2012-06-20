<?php
	define('TRIPL_CLIENT_ID','4fe14549e046251762000045');
	define('TRIPL_CLIENT_SECRET','33ba97ee45d4978fc02a71d8a9d77c27066442bd4fa6c36e697334a8af1145be');
	define('TRIPL_API_BASE','http://anton.dev.tripl.com/api/v1/');

	function __autoload( $class ){
		require_once( lcfirst($class) . ".php" );
	}