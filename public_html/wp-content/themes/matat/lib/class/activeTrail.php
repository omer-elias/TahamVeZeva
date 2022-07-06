<?php
/**
 * Created by PhpStorm.
 * User: amitmatat
 * Date: 26/04/2018
 * Time: 10:56
 */

namespace matat;


class activeTrail
{

    public $table_name;
    private $userName;
    private $apiToken;
    public $contactListId = 135173;

    public function __construct()
    {

        //$this->userName      = 'michal@tekoafarms.co.il';
        $this->apiToken = '0XAB07F9D21A175FC7272C5F6974528C2802C74619FB97FA83CA3C57E607C64E5CAD9BD4D3F916A64CD8A7E2615BF6EF0E';
        // $this->contactListId = 135173;


        add_action('wp_ajax_matat_get_form_data', array($this, 'matat_get_form_data'));
        add_action('wp_ajax_nopriv_matat_get_form_data', array($this, 'matat_get_form_data'));


    }


    public function matat_get_form_data()
    {

        check_ajax_referer('csrf-token', 'security');


        $param = array();
        parse_str($_POST['data'], $param);

        $this->matat_activetrail_Subscribed($param);
        die();
    }

    function matat_activetrail_Subscribed($param)
    {


        //Add contact to a given group
        //Put your group id here
        $groupId = $this->contactListId;
        //Your authorization key (eg. 0x......)
        $authId = $this->apiToken;
        $url = 'http://webapi.mymarketing.co.il/api/groups/' . $groupId . '/members';


        //open connection
        $ch = curl_init();
        //Prepare headers
        $headr = array();
        $headr[] = 'Content-type: application/json';
        $headr[] = 'Authorization: ' . $authId;

        //Prepare POST body
        $params = array(
            'email' => $param['email_address'],
            'first_name' => $param['full_name'],

        );

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);


        return $result;
    }

}

new activeTrail();

