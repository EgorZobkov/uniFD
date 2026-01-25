<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Sms;

class Smsru{

    public $alias = "smsru";

    public function send($params=[]){
        global $app;

        $key = $params["key"] ?: $app->settings->integration_sms_service_data["key"];
        $method_confirmation = $params["method_confirmation"] ?: $app->settings->integration_sms_service_data["method_confirmation"];

        if($method_confirmation == "by_call"){
            $result = _json_decode(curl("get","https://sms.ru/callcheck/add?api_id=".$key."&phone=".$params["to"]."&json=1"));
            if($result["call_phone"]){
                return ["status"=>true, "call_phone"=>$result["call_phone_pretty"], "service_internal_id"=>$result["check_id"], "answer"=>$result];
            }else{
                return ["status"=>false];
            }
        }else{
            $result = _json_decode(curl("get","https://sms.ru/sms/send?api_id=".$key."&to=".$params["to"]."&msg=".urlencode($params["code"])."&json=1"));
            if($result){
                return ["status"=>true, "code"=>$params["code"], "answer"=>$result];
            }else{
                return ["status"=>false];
            }
        }

    }

    public function webhook($action=null){
        global $app;

        $hash = "";
        foreach ($_POST["data"] as $entry) {
            $hash .= $entry;
        }

        if ($_POST["hash"] == hash("sha256",$app->settings->integration_sms_service_data["key"].$hash)) {
            
            foreach ($_POST["data"] as $entry) {
                $lines = explode("\n",$entry);
                switch ($lines[0]) {
                    case "sms_status":
                        $sms_id = $lines[1];
                        $sms_status = $lines[2];
                        $unix_timestamp = $lines[3];

                        break;
                    case "callcheck_status":
                        $check_id = $lines[1];
                        $check_status = $lines[2];
                        $unix_timestamp = $lines[3];

                        if ($check_status == "401") {
                            $app->system->changeStatusVerifyCodeByInternalId(1,$check_id);
                        }
                        
                        break;
                }
            }

        }

        echo "100";

    }

    public function test($params=[]){
        global $app;

        return $this->send(["key"=>$params["integration_sms_service_data"]["key"], "method_confirmation"=>$params["integration_sms_service_data"]["method_confirmation"], "to"=>$app->settings->contact_phone, "text"=>generateNumberCode($app->settings->confirmation_length_code), "code"=>generateNumberCode($app->settings->confirmation_length_code)]);

    }

    public function fieldsForm($params=[]){
        global $app;

        return '

          <div class="col-12 mb-3">

            <label class="switch">
              <input type="checkbox" name="integration_sms_service_data[method_confirmation]" value="by_call" class="switch-input" '.($app->settings->integration_sms_service_data["method_confirmation"] ? 'checked=""' : '').' >
              <span class="switch-toggle-slider">
                <span class="switch-on"></span>
                <span class="switch-off"></span>
              </span>
              <span class="switch-label">'.translate("tr_0b776fae2096c701d704399111e76a7a").'</span>
            </label>

          </div>

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >'.translate("tr_150c7abfca6c489fee5cb82fbb7a9bc4").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <strong>'.$app->system->buildWebhook("sms", $this->alias).'</strong>
              </div>
            </div>

          </div>

          <div class="col-12">

            <label class="form-label mb-2" >'.translate("tr_6252727443e5a8de378aba95bd2405c8").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[key]" class="form-control" value="'.$app->settings->integration_sms_service_data["key"].'" /> 
              </div>
            </div>

          </div>

        ';

    }


}