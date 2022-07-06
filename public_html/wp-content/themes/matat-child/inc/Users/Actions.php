<?php

namespace Matat\Users;

use Matat\Singleton;

class Actions
{

    use Singleton;

    private function __construct()
    {

        add_action('wp_ajax_nopriv_matat_user_register', array($this, 'user_register'));
        add_action('wp_ajax_nopriv_matat_user_login', array($this, 'user_login'));
        add_action('wp_ajax_update_user_info', array($this, 'update_user_info'));
        add_action('wp_ajax_save_account_password', array($this, 'save_account_password'));
    }

    function user_register()
    {

        check_admin_referer('register', 'security');

        parse_str($_POST['data'], $data);
        //debug($data);
        $args = array();


        if (!empty($data['register_first_name'])) {
            $args['first_name'] = sanitize_text_field($data['register_first_name']);
        }

        if (!empty($data['register_last_name'])) {
            $args['last_name'] = sanitize_text_field($data['register_last_name']);
        }

        if (!empty($data['register_email'])) {
            $user_email = sanitize_email($data['register_email']);
        }

        if (!empty($data['register_password'])) {
            $user_pass = sanitize_text_field($data['register_password']);
        }

        if (strlen($user_pass) < 6) {
            wp_send_json_error('סיסמה צריכה להיות לפחות 6 תווים');
        }

        $user_id = wc_create_new_customer($user_email, $user_email, $user_pass, $args);

        if (is_wp_error($user_id)) {
            wp_send_json_error($user_id->get_error_message());
        }


        update_user_meta($user_id, "billing_first_name", $args['last_name']);
        update_user_meta($user_id, "billing_last_name", $args['last_name']);
        update_user_meta($user_id, "billing_email", $user_email);
        if ($data['term'] == 'true') {
            update_user_meta($user_id, "newsletter_approval", true);
        }

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);

        wp_send_json_success('נרשמת בהצלחה');
    }

    function user_login()
    {


        check_admin_referer('login', 'security');

        parse_str($_POST['data'], $data);

        if (!empty($data['login_email'])) {
            $email = sanitize_email($data['login_email']);
        }

        if (!empty($data['login_password'])) {
            $password = sanitize_text_field($data['login_password']);
        }

        if (!empty($data['remember'])) {
            $remember = true;
        } else {
            $remember = false;
        }

        $creds = array(
            'user_login' => $email,
            'user_password' => $password,
            'remember' => $remember
        );

        $user = wp_signon($creds, false);

        if (is_wp_error($user)) {
            wp_send_json_error($user->get_error_message());
        } else {
            wp_send_json_success('התחברת בהצלחה');
        }

    }

    function update_user_info()
    {
        check_admin_referer('csrf-token', 'security');

        parse_str($_POST['data'], $data);
        $customer = new \WC_Customer(get_current_user_id());

        $errors = [];
        foreach ($data as $key => $value) {
            try {
                $customer->{"set_{$key}"}($value);
            } catch (\Exception $e) {
                $errors = $e->getMessage();
            }
        }

        $customer->save();

        if (!empty($errors)) {
            wp_send_json_error(implode(' / ', $errors));
        } else {
            wp_send_json_success(__('Info was saved.', 'matat'));
        }
    }

    function save_account_password()
    {
        check_admin_referer('csrf-token', 'security');

        $user = wp_get_current_user();

        $result = wp_update_user(array(
            'ID' => $user->ID,
            'user_pass' => sanitize_text_field($_POST['password1']),
        ));

        if (!is_wp_error($result)) {
            wp_send_json_success(__('Password Changed.', 'matat'));
        } else {
            wp_send_json_error($result->get_error_message());
        }
    }

}