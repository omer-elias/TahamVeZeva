<?php
/**
 * Created by PhpStorm.
 * User: textme
 * Date: 2020-02-22
 * Time: 21:30
 */

namespace matat;


class woo_email
{

    public function __construct()
    {

        add_filter('woocommerce_email_settings', array($this, 'add_dynamic_settings'));

        add_action('woocommerce_email_classes', array($this, 'loop_all_email_list'));



    }

    public function add_dynamic_settings($settings)
    {

        $new_settings = array();

        foreach ($settings as $setting) {

            if (isset($setting['id']) && 'email_template_options' == $setting['id'] &&
                isset($setting['type']) && 'sectionend' == $setting['type']) {

                $new_settings[] = array(
                    'id' => 'email_facebook_url',
                    'title' => 'עמוד פייסבוק',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );


                $new_settings[] = array(
                    'id' => 'email_twitter_url',
                    'title' => 'עמוד טוויטר',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );

                $new_settings[] = array(
                    'id' => 'email_instagram_url',
                    'title' => 'עמוד instagram',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );

                $new_settings[] = array(
                    'id' => 'email_pinterest_url',
                    'title' => 'עמוד pinterest',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );

                $new_settings[] = array(
                    'id' => 'email_appstore_url',
                    'title' => 'לינק לאפליקציית ios',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );

                $new_settings[] = array(
                    'id' => 'email_playstore_url',
                    'title' => 'לינק לאפליקציית אנדרואיד',
                    'type' => 'url',
                    'description' => 'במידה וריק, האיקון לא יוצג',
                );

                $new_settings[] = array(
                    'id' => 'email_banner_url',
                    'title' => 'לינק לבאנר פרסומי',
                    'type' => 'url',
                    'description' => 'במידה וישמר לינק + תמונה באנר - יוצג בתחתית המייל באנר פרסומי',
                );

                $new_settings[] = array(
                    'id' => 'email_banner_image',
                    'title' => 'תמונה לבאנר פרסומי',
                    'type' => 'url',
                    'description' => 'לשמור את הנתיב המלא לתמונה',
                );
            }

            $new_settings[] = $setting;
        }

        return $new_settings;
    }


    public function add_custom_email_setting($form_fields)
    {

        $form_fields['banner_img'] = [
            'title' => 'תמונת Cover',
            'description' => 'תמונה שתוצג בראש המייל',
            'type' => 'text',
            //'default' => $this->get_defalt_imgae($_GET['section'])
        ];

        return $form_fields;
    }

    public function loop_all_email_list($email_class_list)
    {

        foreach ($email_class_list as $email_class) {

//            debug( $email_class->id);
            add_action('woocommerce_settings_api_form_fields_' . $email_class->id, array($this, 'add_custom_email_setting'), 10, 1);
        }

        return $email_class_list;
    }
}

new woo_email();