<?php
/**
 * Created by PhpStorm.
 * User: amitmatat
 * Date: 18/11/2018
 * Time: 18:51
 */

namespace matat;


class Textme {

	private $userName;
	private $password;
	private $contactListId;


	function __construct() {
		$this->userName      = '';
		$this->password      = '';
		$this->contactListId = '';
	}


	public function addUserToList( $arr ) {
		$curl = curl_init();


		$phone = $arr['phone'];
		$first = $arr['first'];
		$last  = $arr['last'];
		$email = $arr['email'];

		$xml = "<?xml version='1.0' encoding='UTF-8'?>
				<addNumCL>
				<user>
				<username>$this->userName</username>
				<password>$this->password</password>
				</user>
				<cl>
				<id>$this->contactListId</id>
				<destinations>
				 <destination>
				 <phone>$phone</phone>
				 <df1>$first</df1>
				 <df2>$last</df2>
				 <df3>$email</df3>
				 </destination>
				</destinations>
				</cl>
				</addNumCL>";

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => "https://my.textme.co.il/api",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 30,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",
			CURLOPT_POSTFIELDS     => $xml,
			CURLOPT_HTTPHEADER     => array(
				"Cache-Control: no-cache",
				"Content-Type: application/xml",
				"Postman-Token: 4c9db6df-2e34-46f4-a64e-b40229420cbd"
			),
		) );

		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );

		if ( $err ) {
			echo "cURL Error #:" . $err;
		} else {
			//debug($response);
		}
	}

}

//new Textme();