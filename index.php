<?php
	error_reporting( E_ALL );
	require_once( 'config.php' );

	if( isset( $_GET['code'] ) ){

		$user = User::createFetchAccessToken( $_GET['code'] );

?>

<p>Successfully retrieved access token for user ID <?= $user->id ?></p>
<p><a href="fetchuser.php?user_id=<?= $user->id ?>">Fetch data from tripl</a></p>

<?php

	}else{
?>

<a href="redirect.php">Connect with Tripl</a>	

<?php
	}