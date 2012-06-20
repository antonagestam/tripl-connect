<?php
	class User{

		protected $data = null;

		public function __set( $key, $var ){

			return $this->data[$key] = $var;

		}

		public function __get( $key ){

			if( !isset( $this->data[$key] ) )
				return null;
			
			return $this->data[$key];
			
		}

		public function __construct( $data = null ){

			$this->data = $data;

		}

		public function save(){

			$json = json_encode($this->data);
			file_put_contents('user'.$this->id.'.json',$json);

		}

		public static function load($user_id){

			$json = file_get_contents('user'.$user_id.'.json');
			$class = __CLASS__;
			return new $class( json_decode($json,true) );

		}

		public static function createFetchAccessToken( $authToken ){

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
					'code' => $authToken,
					'devMode' => 1,
				),
			);

			curl_setopt_array( $ch, $options );

			$result = curl_exec( $ch );

			if( curl_getinfo( $ch, CURLINFO_HTTP_CODE ) != 200 ){
				
				echo "Something went wrong when trying to get access token from tripl<br/><pre>";
				var_dump($result);
				exit;

			}else{

				$data = json_decode( $result, true );
				$data = $data['data'];

				if( !isset( $data['access_token'], $data['user_id'] ) )
					throw new Exception("Did not revieve valid data from Tripl, <pre>" . print_r( $result, true ) . "</pre>");

				$user = new User();
				$user->access_token = $data['access_token'];
				$user->id = $data['user_id'];
				$user->save();
				return $user;

			}

		}

		private function fetchDataFromTripl($api = 'user/me'){

			if( is_null( $this->access_token ) )
				throw new Exception("Can't fetch data, invalid access token");

			$params = http_build_query(array(
				'access_token' => $this->access_token,
				'devMode' => 1
			));

			$url = TRIPL_API_BASE . $api . '?' . $params;
			
			$ch = curl_init();
			$options = array(
				CURLOPT_URL => $url,
				//CURLOPT_USERPWD => "tripl:triplnewsummer",
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_0,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HEADER => false
			);

			curl_setopt_array( $ch, $options );

			$result = curl_exec( $ch );

			if( ( $code = curl_getinfo( $ch, CURLINFO_HTTP_CODE ) ) != 200 )
				throw new Exception( $result );

			return $result;

		}

		public function fetchUserFromTripl(){
			$data = $this->fetchDataFromTripl();
			$data = json_decode( $data, true );
			$data = $data['data'];

			$fields = array('name' => 'full_name','gender','age','photo_url_25','photo_url_50','photo_url_125');

			foreach( $fields as $local => $remote ){
				$local = is_numeric( $local ) ? $remote : $local;
				$this->$local = $data[ $remote ];
			}

			$this->save();

		}

	}