<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Sms;

class Mobizonkz{

    public $alias = "mobizonkz";

    public function send($params=[]){
        global $app;

        $key = $params["key"] ?: $app->settings->integration_sms_service_data["key"];

        $domain = $_SERVER['HTTP_HOST'];
        
        $message = "Vash kod podtverzhdeniya dlya {$domain}: {$params['code']}\n\n@{$domain} #{$params['code']}";

        $result = _json_decode(curl("get","https://api.mobizon.kz/service/message/sendsmsmessage", ["recipient"=>$params["to"], "text"=>$message, "apiKey"=>$key]));
        
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

        return $this->send(["key"=>$params["integration_sms_service_data"]["key"], "to"=>$app->settings->contact_phone, "text"=>generateNumberCode($app->settings->confirmation_length_code), "code"=>generateNumberCode($app->settings->confirmation_length_code)]);

    }

    public function fieldsForm($params=[]){
        global $app;

        return '

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >Api key</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[key]" class="form-control" value="'.$app->settings->integration_sms_service_data["key"].'" /> 
              </div>
            </div>

          </div>

          <input type="hidden" name="integration_sms_service_data[method_confirmation]" value="" />

        ';

    }


}