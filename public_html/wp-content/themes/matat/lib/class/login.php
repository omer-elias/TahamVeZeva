<?php
/**
 * Created by PhpStorm.
 * User: amitmatat
 * Date: 13/10/2018
 * Time: 11:13
 */

namespace matat;


class login {

	function __construct() {

		add_action( 'wp_ajax_matat_login', array( $this, 'matat_login' ) );
		add_action( 'wp_ajax_nopriv_matat_login', array( $this, 'matat_login' ) );


		add_action( 'wp_ajax_matat_valid_user', array( $this, 'matat_valid_user' ) );
		add_action( 'wp_ajax_nopriv_matat_valid_user', array( $this, 'matat_valid_user' ) );

        add_action( 'wp_ajax_matat_register', array( $this, 'matat_register' ) );
        add_action( 'wp_ajax_nopriv_matat_register', array( $this, 'matat_register' ) );


    }


	public function matat_login() {

		check_ajax_referer( 'csrf-token', 'security' );


		$param = array();
		parse_str( $_POST['data'], $param );


		$creds                  = array();
		$creds['user_login']    = $param['username'];
		$creds['user_password'] = $param['password'];
		$creds['remember']      = isset( $param['remember'] ) ? true : false;
		$user                   = wp_signon( $creds, false );
		if ( is_wp_error( $user ) ) {

			echo json_encode( array(
				'error' => 1,
				'msg'   => 'שם משתמש או סיסמה לא תקינים'
			) );
		} else {
			echo json_encode( array(
				'error' => 0,
				'msg'   => 'התחברת בהצלחה'
			) );
		}


		die();

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
                'display_name' => $param['first'],
                'user_email'   => $param['email']
            );


//            if ( $param['term'] == 'true' ) {
//                $TextMe = new Textme();
//                $TextMe->addUserToList( $param );
//            }

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

	public function matat_valid_user() {
		check_ajax_referer( 'csrf-token', 'security' );


		$user = get_user_by( 'login', $_POST['user'] );

		if ( ! $user->data->ID ) {
			echo 'not_exist';
		}


		die();
	}

}

new login();