<?php
	error_reporting(E_ALL);

	require_once("config.php");

	try{
		$user = User::load($_GET['user_id']);
		$user->fetchUserFromTripl();
	}
	catch( Exception $e ){
		header('Content-type: application/json');
		echo $e->getMessage();
		exit;
	}

	header('Location: showuser.php?user_id=' . $user->id);