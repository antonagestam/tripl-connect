<?php
	error_reporting( E_ALL );
	require_once( 'config.php' );

	if( isset( $_GET['code'] ) ){

		$url = TRIPL_API_BASE . 'auth/token';
		$ch = curl_init();

		$options = array(
			CURLOPT_URL => $url,
			CURLOPT_USERPWD => "tripl:triplnewsummer",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
			CURLOPT_POSTFIELDS => array(
				'client_id' => TRIPL_CLIENT_ID,
				'client_secret' => TRIPL_CLIENT_SECRET,
				'grant_type' => 'authorization_code',
				'code' => $_GET['code']
			)
		);

		curl_setopt_array( $ch, $options );

		$data = curl_exec( $ch );

		if( curl_getinfo( $ch, CURLINFO_HTTP_CODE ) != 200 ){
			
			echo "Something went wrong when trying to get access token from tripl<br/><pre>";
			var_dump($data);

		}else{

			$data = json_decode( $data, true );
			$user = new User();
			$user->access_token = $data['data']['access_token'];
			$user->id = $data['data']['user_id'];
			$user->save();

		}

?>

<p>Successfully retrieved access token from tripl</p>
<p><a href="fetchuser.php?user_id=<?= $user->id ?>">Fetch data from tripl</a></p>

<?php

	}else{
?>

<a href="redirect.php">Connect with Tripl</a>	

<?php
	}