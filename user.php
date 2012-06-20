<?php
	class User{

		protected $data = null;

		public function __set( $key, $var ){

			return $this->data[$key] = $var;

		}

		public function __get( $key ){
			
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

		private function fetchDataFromTripl($api = 'user/me'){

			$params = http_build_query(array(
				'access_token' => $this->access_token
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