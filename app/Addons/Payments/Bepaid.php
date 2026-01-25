<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Bepaid{

    public $alias = "bepaid";
    public $data;

    public function __construct(){
        global $app;
        $this->data = $this->getData();
    }

    public function getData(){
        global $app;
        $data = $app->model->system_payment_services->find("alias=?", [$this->alias]);
        if($data){
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAZgAAAB/CAYAAADSDdTbAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoyNDcxODA5QjI2QUUxMUYwODBBMUIzMjZCQzk4RTZEMCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoyNDcxODA5QzI2QUUxMUYwODBBMUIzMjZCQzk4RTZEMCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjI0NzE4MDk5MjZBRTExRjA4MEExQjMyNkJDOThFNkQwIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjI0NzE4MDlBMjZBRTExRjA4MEExQjMyNkJDOThFNkQwIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+OcznMwAAEJ5JREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        try {

            if($this->data->params->sandbox){
                $checkout["checkout"]["test"] = true;
            }

            $checkout["checkout"]["transaction_type"] = "payment";
            $checkout["checkout"]["attempts"] = 3;
            $checkout["checkout"]["settings"]["notification_url"] = $app->system->buildWebhook("payment", $this->alias);
            $checkout["checkout"]["settings"]["return_url"] = getHost(true) . "/payment/status/order/" . $params["order_id"];
            $checkout["checkout"]["settings"]["success_url"] = getHost(true) . "/payment/status/order/" . $params["order_id"];
            $checkout["checkout"]["settings"]["fail_url"] = getHost(true) . "/payment/status/order/" . $params["order_id"];
            $checkout["checkout"]["settings"]["cancel_url"] = getHost(true) . "/payment/status/order/" . $params["order_id"];

            $checkout["checkout"]["order"]["currency"] = "BYN";
            $checkout["checkout"]["order"]["amount"] = $params["amount"];
            $checkout["checkout"]["order"]["description"] = $params["title"];
            $checkout["checkout"]["order"]["tracking_id"] = $params["order_id"];

            $checkout["checkout"]["payment_method"]["types"] = ["credit_card"];
            $checkout["checkout"]["customer"]["email"] = $params["user_email"];

            $result = _json_decode(curl("post","https://checkout.bepaid.by/ctp/api/checkouts", $checkout, ["Authorization"=>"Basic ".base64_encode($this->data->params->shop_id.":".$this->data->params->secret_key), "Content-Type"=>"application/json", "Accept"=>"application/json", "X-API-Version"=>2]));

            return ["link"=>$result["redirect_url"]];

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
        }

    }

    public function createPayout($data=[]){
        global $app;

        try {



        } catch (Exception $e) {
            logger("Payment ".$this->alias." createPayout error: {$e->getMessage()}");
        }

    }

    public function createRefund($data=[]){
        global $app;

        try {



        } catch (Exception $e) {
            logger("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
        }

    }

    public function callback($action=null){
        global $app;

        try {

            $requestBody = _file_get_contents('php://input');

            $public_key = str_replace(array("\r\n", "\n"), '', $this->data->params->public_key);
            $public_key = chunk_split($public_key, 64);
            $public_key = "-----BEGIN PUBLIC KEY-----\n$public_key-----END PUBLIC KEY-----";

            $signature = base64_decode($signature);

            $key = openssl_pkey_get_public($public_key);

            $result = openssl_verify($requestBody, $signature, $key, OPENSSL_ALGO_SHA256);

            $requestBody = _json_decode($requestBody);

            $order = $app->component->transaction->getOperation($requestBody['tracking_id']);

            if($order){
                $app->component->transaction->callback($order->data, _json_encode($requestBody));
                header("HTTP/1.1 200 OK");
            }else{
                logger("Error payment not found order:".$requestBody['tracking_id']);
                header("HTTP/1.1 404 ERROR");
            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
            header("HTTP/1.1 404 ERROR");
        }

    }

    public function fieldsForm($params=[]){
        global $app;

        return '
        <form class="integrationPaymentForm" >

            <h3>'.$this->data->name.'</h3>

            <div class="row">

                <div class="col-12">

                    <label class="switch">
                      <input type="checkbox" name="status" value="1" class="switch-input" '.($this->data->status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87a4286b7b9bf700423b9277ab24c5f1").'</span>
                    </label>

                </div>

                <div class="col-12 mt-2">

                    <label class="switch">
                      <input type="checkbox" name="params[sandbox]" value="1" class="switch-input" '.($this->data->params->sandbox ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">Sandbox</span>
                    </label>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-1" >'.translate("tr_673b49f1887ca36b7e1d37d4f8c112b9").'</label>

                  <strong>'.$app->system->buildWebhook("payment", $this->alias).'</strong>

                  <div class="alert alert-warning d-flex align-items-center mt-2 mb-0" role="alert">
                    '.translate("tr_d6049d9c844a6dfea6051bfe3f0d7462").'
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cfe494c750a7c11908a7c19249bf200f").'</label>

                  <input type="text" name="title" class="form-control" value="'.$this->data->title.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Shop ID</label>

                  <input type="text" name="params[shop_id]" class="form-control" value="'.$this->data->params->shop_id.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Public key</label>

                  <input type="text" name="params[public_key]" class="form-control" value="'.$this->data->params->public_key.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Secret key</label>

                  <input type="text" name="params[secret_key]" class="form-control" value="'.$this->data->params->secret_key.'" />

                </div>

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </from>
        ';

    }


}