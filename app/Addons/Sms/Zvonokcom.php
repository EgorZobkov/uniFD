<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Sms;

class Zvonokcom{

    public $alias = "zvonokcom";

    public function send($params=[]){
        global $app;

        $key = $params["key"] ?: $app->settings->integration_sms_service_data["key"];
        $campaign_id = $params["campaign_id"] ?: $app->settings->integration_sms_service_data["campaign_id"];
        $method_confirmation = $params["method_confirmation"] ?: $app->settings->integration_sms_service_data["method_confirmation"];

        if($method_confirmation == "by_call"){
            $result = _json_decode(curl("post","https://zvonok.com/manager/cabapi_external/api/v1/phones/confirm/", ["public_key"=>$key, "phone"=>urlencode($params["to"]), "pincode"=>$params["code"], "campaign_id"=>$campaign_id]));

            if($result["status"] != "error"){
                return ["status"=>true, "call_phone"=>$app->settings->integration_sms_service_data["incoming_phone"], "service_internal_id"=>$result["data"]["call_id"], "answer"=>$result];
            }else{
                logger("Sms ".$this->alias." send error: ".print_r($result, true));
                return ["status"=>false];
            }

        }else{
            $result = _json_decode(curl("post","https://zvonok.com/manager/cabapi_external/api/v1/phones/tellcode/", ["public_key"=>$key, "phone"=>urlencode($params["to"]), "pincode"=>$params["code"], "campaign_id"=>$campaign_id]));
            
            if($result["status"] != "error"){
                return ["status"=>true, "code"=>$params["code"], "answer"=>$result];
            }else{
                return ["status"=>false];
            }
        }

    }

    public function webhook($action=null){
        global $app;

        if($_POST["status"] == "pincode_ok"){

          $app->system->changeStatusVerifyCodeByInternalId(1,$_POST["id"]);

        }

    }

    public function test($params=[]){
        global $app;

        return $this->send(["key"=>$params["integration_sms_service_data"]["key"], "campaign_id"=>$params["integration_sms_service_data"]["campaign_id"], "to"=>$app->settings->contact_phone, "text"=>generateNumberCode($app->settings->confirmation_length_code), "code"=>generateNumberCode($app->settings->confirmation_length_code)]);

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
                <strong>'.$app->system->buildWebhook("sms", $this->alias).'?id={ct_call_id}&status={ct_status}</strong>
              </div>
            </div>

          </div>

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >'.translate("tr_6252727443e5a8de378aba95bd2405c8").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[key]" class="form-control" value="'.$app->settings->integration_sms_service_data["key"].'" /> 
              </div>
            </div>

          </div>

          <div class="col-12 mb-3">

            <label class="form-label mb-2" >'.translate("tr_51b81c08a1c177618f7a75847a02d259").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[campaign_id]" class="form-control" value="'.$app->settings->integration_sms_service_data["campaign_id"].'" /> 
              </div>
            </div>

          </div>

          <div class="col-12">

            <label class="form-label mb-2" >'.translate("tr_3584ec0a3b3c33819c3296a89cff8fe3").'</label>

            <div class="row" >
              <div class="col-12 col-md-6" >
                <input type="text" name="integration_sms_service_data[incoming_phone]" class="form-control" value="'.$app->settings->integration_sms_service_data["incoming_phone"].'" /> 
              </div>
            </div>

            <div class="alert alert-warning d-flex align-items-center mt-2 mb-0" role="alert">
              '.translate("tr_def36a633f1f00fe224767cb503fc585").'
            </div>

          </div>

        ';

    }


}