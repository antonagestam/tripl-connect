<?php
	require_once('config.php');
	$params = array(
		'client_id' => TRIPL_CLIENT_ID,
		'response_type' => 'code',
		'redirect_uri' => 'http://localhost:8888/',
		'scope' => 'extended',
		
	);
	$url = TRIPL_API_BASE . 'auth/authorize?' . http_build_query( $params );
	header( 'Location: ' . $url );