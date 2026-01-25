<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Clickuz{

    public $alias = "clickuz";
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
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAM4AAADQCAYAAABPw14vAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpCNzRCMERCNzI3RTExMUYwOTA2QTlDQzQ3NkI0N0VEOSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpCNzRCMERCODI3RTExMUYwOTA2QTlDQzQ3NkI0N0VEOSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkI3NEIwREI1MjdFMTExRjA5MDZBOUNDNDc2QjQ3RUQ5IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkI3NEIwREI2MjdFMTExRjA5MDZBOUNDNDc2QjQ3RUQ5Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+K5TEbgAAFrxJREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        try {

            return ["link"=>"https://my.click.uz/services/pay?service_id=".$this->data->params->service_id."&merchant_id=".$this->data->params->merchant_id."&amount=".$params["amount"]."&transaction_param=".$params["order_id"]."&return_url=".getHost(true) . "/payment/status/order/" . $params["order_id"]."&merchant_user_id=".$this->data->params->merchant_user_id];
            
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

        $requestBody = _json_decode(file_get_contents('php://input'));

        debug($requestBody);
        debug($_REQUEST);

        // if($requestBody){

        //     try {

        //         if ($token == $requestBody['Token']) {

        //             if ($requestBody['Status'] == 'CONFIRMED') {

        //                 $order = $app->component->transaction->getOperation($requestBody['OrderId']);

        //                 if($order){
        //                     $app->component->transaction->callback($order->data, _json_encode($requestBody));
        //                     header("HTTP/1.1 200 OK");
        //                 }else{
        //                     logger("Error payment not found order:".$requestBody['OrderId']);
        //                     header("HTTP/1.1 404 ERROR");
        //                 }

        //             }

        //         }

        //     } catch (Exception $e) {
        //         logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
        //         header("HTTP/1.1 404 ERROR");
        //     }

        // }

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

                  <label class="form-label mb-2" >Merchant id</label>

                  <input type="text" name="params[merchant_id]" class="form-control" value="'.$this->data->params->merchant_id.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Service id</label>

                  <input type="text" name="params[service_id]" class="form-control" value="'.$this->data->params->service_id.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Merchant user id</label>

                  <input type="text" name="params[merchant_user_id]" class="form-control" value="'.$this->data->params->merchant_user_id.'" />

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