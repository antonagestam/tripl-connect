<?php
	error_reporting(E_ALL);

	require_once("config.php");

	$user = User::load($_GET['user_id']);
	$user->fetchUserFromTripl();

	header('Location: showuser.php?user_id=' . $user->id);