<?php
	error_reporting(E_ALL);

	require_once("config.php");

	$user = User::load(38328);
	$user->fetchUserFromTripl();