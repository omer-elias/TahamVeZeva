<?php
/**
 * Created by PhpStorm.
 * User: Asaf
 * Date: 18/07/2018
 * Time: 11:19
 */

/**
 * Remove Woocommerce style
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


//Remove tabs
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
//add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 40 );


/**
 * @param $columns
 * @return mixed
 * Remove columns in product admin view
 */
function matat_remove_product_columns($columns)
{
// remove the Yoast SEO columns
    unset($columns['wpseo-score']);
    unset($columns['wpseo-title']);
    unset($columns['wpseo-metadesc']);
    unset($columns['wpseo-focuskw']);
    unset($columns['wpseo-score-readability']);
    unset($columns['product_tag']);
    //unset( $columns['date'] );
    //unset( $columns['product_type'] );
    //unset( $columns['is_in_stock'] );
    //unset( $columns['featured'] );

    return $columns;
}

//add_filter('manage_edit-product_columns', 'matat_remove_product_columns');




/**
 * @param $fields
 * @return mixed
 * Make change in checkout fields
 */
function matat_custom_checkout_fields($fields)
{
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {

            //  debug($field);

            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'input-wrap';
            $field['label_class'][] = 'sr-only';

            // add form-control to the actual input
            $field['input_class'][] = 'form-input';
        }
    }


    $fields['billing']['billing_first_name']['placeholder'] = 'שם פרטי';
    $fields['billing']['billing_last_name']['placeholder'] = 'שם משפחה';
    $fields['billing']['billing_company']['placeholder'] = 'שם חברה';
    $fields['billing']['billing_postcode']['placeholder'] = 'מיקוד';
    $fields['billing']['billing_city']['placeholder'] = 'עיר';
    $fields['billing']['billing_email']['placeholder'] = 'דוא"ל';
    $fields['billing']['billing_phone']['placeholder'] = 'טלפון';


    $fields['billing']['billing_first_name']['class'][] = 'half';
    $fields['billing']['billing_last_name']['class'][] = 'half';
    $fields['billing']['billing_phone']['class'][] = 'half';
    $fields['billing']['billing_company']['class'][] = 'half';
    $fields['billing']['billing_city']['class'][] = 'half';
    $fields['billing']['billing_postcode']['class'][] = 'half';


    $fields['billing']['billing_email']['priority'] = 1;
    $fields['billing']['billing_first_name']['priority'] = 2;
    $fields['billing']['billing_last_name']['priority'] = 3;
    $fields['billing']['billing_phone']['priority'] = 4;
    $fields['billing']['billing_company']['priority'] = 5;
    $fields['billing']['billing_address_1']['priority'] = 6;
    $fields['billing']['billing_address_2']['priority'] = 7;
    $fields['billing']['billing_city']['priority'] = 8;
    $fields['billing']['billing_postcode']['priority'] = 9;
    $fields['billing']['billing_country']['priority'] = 20;
    $fields['billing']['billing_state']['priority'] = 21;

    return $fields;
}

//add_filter('woocommerce_checkout_fields', 'matat_custom_checkout_fields');

/**
 * @param $field
 * @param $key
 * @param $args
 * @param $value
 * @return mixed
 * Remove class in checkout wrapper
 */

function clean_checkout_fields_class_attribute_values( $field, $key, $args, $value ){
    if( is_checkout() ){
        // remove "form-row"
        $field = str_replace( array('form-row', 'form-row'), array('form-group', 'form-group'), $field);
    }

    return $field;
}

//add_filter('woocommerce_form_field_country', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_state', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_textarea', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_checkbox', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_password', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_text', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_email', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_tel', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_number', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_select', 'clean_checkout_fields_class_attribute_values', 20, 4);
//add_filter('woocommerce_form_field_radio', 'clean_checkout_fields_class_attribute_values', 20, 4);


function matat_inventory_product_data_custom_field()
{

    woocommerce_wp_text_input(
        array(
            'id' => '_user_limit',
            'label' => 'הגבלת כרטיסים למשתמש',
            //'placeholder' => 'Custom text field',
            'type' => 'number',
            'desc_tip' => 'true',
            'description' => 'משתמש לא יוכל לרכוש מעבר לכמות זו'
        )
    );


}

//add_action('woocommerce_product_options_inventory_product_data', 'matat_inventory_product_data_custom_field');


/** Hook callback function to save custom fields information */
function matat_save_inventory_product_data_custom_field($post_id)
{
    // Save Text Field

    $user_limit = $_POST['_user_limit'];
    if (!empty($user_limit)) {
        update_post_meta($post_id, '_user_limit', esc_attr($user_limit));
    } else {
        delete_post_meta($post_id, '_user_limit');
    }

}

//add_action('woocommerce_process_product_meta', 'matat_save_inventory_product_data_custom_field');


/**
 * Hook to update order in checkout
 * Need create template /woocommerce/checkout/form-delivery.php 
 */
add_filter('woocommerce_update_order_review_fragments', 'matat_order_fragments_split_shipping', 10, 1);
function matat_order_fragments_split_shipping($order_fragments) {

    ob_start();
    wc_get_template('checkout/form-delivery.php');
    $template = ob_get_clean();

    $order_fragments['.shipping-method-holder'] = $template;

    return $order_fragments;

}

