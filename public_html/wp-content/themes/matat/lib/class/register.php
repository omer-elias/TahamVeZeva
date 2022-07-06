<?php
/**
 * Created by PhpStorm.
 * User: amitmatat
 * Date: 18/11/2018
 * Time: 17:52
 */

namespace matat;


class register {

	function __construct() {

		add_action( 'wp_ajax_matat_register', array( $this, 'matat_register' ) );
		add_action( 'wp_ajax_nopriv_matat_register', array( $this, 'matat_register' ) );

	}

	function matat_register() {


		check_ajax_referer( 'csrf-token', 'security' );


		$param = array();
		parse_str( $_POST['data'], $param );


		//debug($param);

		$user_id = username_exists( $param['email'] );
		if ( ! $user_id and email_exists( $param['email'] ) == false ) {

			$userdata = array(
				'user_login'   => $param['email'],
				'user_pass'    => $param['password'],
				'first_name'   => $param['first'],
				'last_name'    => $param['last'],
				'display_name' => $param['first'] . ' ' . $param['last'],
				'user_email'   => $param['email']
			);


			if ( $param['term'] == 'true' ) {
				$TextMe = new Textme();
				$TextMe->addUserToList( $param );
			}

			$user_id = wp_insert_user( $userdata );

			update_user_meta( $user_id, 'billing_phone', $param['phone'] );

			wp_set_current_user( $user_id );
			wp_set_auth_cookie( $user_id );

			echo json_encode( array(
				'error' => false,
				'id'    => $user_id,
				'msg'   => 'התחברת בהצלחה'
			) );

		} else {
			echo json_encode( array(
				'error' => true,
				'msg'   => 'כתובת מייל קיימת באתר'
			) );
		}


		die();
	}

}

new register();