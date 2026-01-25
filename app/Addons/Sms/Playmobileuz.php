<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Sms;

class Playmobileuz{

    public $alias = "playmobileuz";

    public function send($params=[]){
        global $app;

        $login = $params["login"] ?: $app->settings->integration_sms_service_data["login"];
        $password = $params["password"] ?: $app->settings->integration_sms_service_data["password"];

        $params['messages'] = [
            "recipient" => trim($params["to"], '+'),
            "message-id" => mt_rand(1000000,9000000),
            "sms" => [
                "originator" => '3700',
                "content" => [
                    "text" => $params["text"]
                ]
            ]
        ];

        $result = _json_decode(curl("get","http://91.204.239.44/broker-api/send", $params, ['Content-Type: application/json', 'Authorization: Basic '.base64_encode($login.":".$password)]));
        
        if($result){
            return ["status"=>true, "code"=>$params["code"], "answer"=>$result];
        }else{
            return ["status"=>false];
        }

    }

    public function webhook($action=null){
        global $app;



    }

    public function test($params=[]){
        global $app;

        return $this->send(["login"=>$params["integration_sms_service_data"]["login"],"password"=>$params["integration_sms_service_data"]["password"], "method_confirmation"=>$params["integration_sms_service_data"]["method_confirmation"], "to"=>$app->settings->contact_phone, "text"=>generateNumberCode($app->settings->confirmation_length_code), "code"=>generateNumberCode($app->settings->confirmation_length_code)]);

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

          <div class="col-12">

            <label class="form-label mb-2" >'.translate("tr_5ebe553e01799a927b1d045924bbd4fd").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[password]" class="form-control" value="'.$app->settings->integration_sms_service_data["password"].'" /> 
              </div>
            </div>

          </div>

          <input type="hidden" name="integration_sms_service_data[method_confirmation]" value="" />

        ';

    }


}