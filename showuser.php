<?php
	error_reporting(E_ALL);

	require_once("config.php");

	$user = User::load($_GET['user_id']);
	
	echo '<img src="' . $user->photo_url_125 . '" /><p>Signed in via <em>Tripl</em> as ' . $user->name . '</p>';