<?php
	error_reporting(E_ALL);

	require_once("config.php");

	$user = User::load(38328);
	
	echo '<img src="' . $user->photo_url_125 . '" /><p>Signed in via <em>Tripl</em> as ' . $user->name . '</p>';