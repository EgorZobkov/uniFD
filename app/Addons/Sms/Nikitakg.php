<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Sms;

class Nikitakg{

    public $alias = "nikitakg";

    public function send($params=[]){
        global $app;

        $login = $params["login"] ?: $app->settings->integration_sms_service_data["login"];
        $password = $params["password"] ?: $app->settings->integration_sms_service_data["password"];
        $label = $params["label"] ?: $app->settings->integration_sms_service_data["label"];

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
            "<message>".
                "<login>" . $login . "</login>".
                "<pwd>" . $password . "</pwd>".
                "<id>" . mt_rand(1000000,9999999) . "</id>".
                "<sender>" . $label . "</sender>".
                "<text>" . $params["code"] . "</text>".
                "<phones>".
                "<phone>" . $params["to"] . "</phone>".
                "</phones>".
            "</message>";   

        $result = $this->curl("http://smspro.nikita.kg/api/message", $xml);

        if($result){
            return ["status"=>true, "code"=>$params["code"], "answer"=>$result];
        }else{
            return ["status"=>false];
        }

    }

    function curl ($url,$postdata) {
        $uagent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)";

        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "c://coo.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE,"c://coo.txt");

        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        return $header;
    }

    public function webhook($action=null){
        global $app;

    }

    public function test($params=[]){
        global $app;

        return $this->send(["login"=>$params["integration_sms_service_data"]["login"], "password"=>$params["integration_sms_service_data"]["password"], "label"=>$params["integration_sms_service_data"]["label"], "to"=>$app->settings->contact_phone, "text"=>generateNumberCode($app->settings->confirmation_length_code), "code"=>generateNumberCode($app->settings->confirmation_length_code)]);

    }

    public function fieldsForm($params=[]){
        global $app;

        return '

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >'.translate("tr_5fe5313dd98f8f5c31ab39c22b629759").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[login]" class="form-control" value="'.$app->settings->integration_sms_service_data["login"].'" /> 
              </div>
            </div>

          </div>

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >'.translate("tr_5ebe553e01799a927b1d045924bbd4fd").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[password]" class="form-control" value="'.$app->settings->integration_sms_service_data["password"].'" /> 
              </div>
            </div>

          </div>

          <div class="col-12">

            <label class="form-label mb-2" >'.translate("tr_4c69bb5b559c2125c4095b7740ae02fc").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[label]" class="form-control" value="'.$app->settings->integration_sms_service_data["label"].'" /> 
              </div>
            </div>

          </div>

          <input type="hidden" name="integration_sms_service_data[method_confirmation]" value="" />

        ';

    }


}