<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

use YooKassa\Client;
use YooKassa\Model\Notification\NotificationSucceeded;
use YooKassa\Model\Notification\NotificationWaitingForCapture;
use YooKassa\Model\Notification\NotificationEventType;
use YooKassa\Model\Payment\PaymentStatus;

class Yookassa{

    public $alias = "yookassa";
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
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEMAAAAvCAYAAAC4/HdSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMC1jMDAxIDc5LmMwMjA0YjJkZWYsIDIwMjMvMDIvMDItMTI6MTQ6MjQgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCAyNC40IChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0NzlENkVFRDM0NzAxMUVGQjExMjhEMEJDREFDN0MyNyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0NzlENkVFRTM0NzAxMUVGQjExMjhEMEJDREFDN0MyNyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjQ3OUQ2RUVCMzQ3MDExRUZCMTEyOEQwQkNEQUM3QzI3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjQ3OUQ2RUVDMzQ3MDExRUZCMTEyOEQwQkNEQUM3QzI3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+zVYPyQAACnNJREFUeNrU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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        $client = new Client();

        $client->setAuth($this->data->params->id, $this->data->params->key);

        try {
        
            if($this->data->params->receipt){

                $payment = $client->createPayment(
                    array(
                        "amount" => array(
                            "value" => numberFormat($params["amount"],2,".",""), 
                            "currency" => $this->data->params->currency,
                        ),          
                        "confirmation" => array(
                            "type" => "redirect",
                            'return_url' => getHost(true) . "/payment/status/order/" . $params["order_id"],
                        ),
                        'capture' => true,
                        'description' => $params["title"],
                        'metadata' => array(
                            'order_id' => $params["order_id"],
                        ),          
                        "receipt" => array(
                            "customer" => array(
                                "full_name" => $params["user_name"],
                                "phone" => $params["user_phone"],
                                "email" => $params["user_email"],
                            ),
                            "items" => array(
                                array(
                                    "description" => $params["title"],
                                    "quantity" => "1.00",
                                    "amount" => array(
                                        "value" => numberFormat($params["amount"],2,".",""),
                                        "currency" =>  $this->data->params->currency
                                    ),
                                    "vat_code" => $this->data->params->vat,
                                    "tax_system_code" => $this->data->params->tax,
                                    "payment_mode" => "full_prepayment",
                                    "payment_subject" => "payment"
                                )
                            )
                        )
                    ),
                    uniqid('', true)
                );

            }else{

                $payment = $client->createPayment(
                    array(
                        'amount' => array(
                            'value' => numberFormat($params["amount"],2,".",""),
                            'currency' => $this->data->params->currency,
                        ),
                        'confirmation' => array(
                            'type' => 'redirect',
                            'return_url' => getHost(true) . "/payment/status/order/" . $params["order_id"],
                        ),
                        'capture' => true,
                        'description' => $params["title"],
                        'metadata' => array(
                            'order_id' => $params["order_id"],
                        )
                    ),
                    uniqid('', true)
                );   

            }

            return ["link"=>$payment["confirmation"]["confirmation_url"]];

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

        $client = new Client();

        $client->setAuth($this->data->params->id, $this->data->params->key);

        try {

            $refundBuilder = \YooKassa\Request\Refunds\CreateRefundRequest::builder();

            if($this->data->params->receipt){

                $refundBuilder
                            ->setPaymentId($data->operation->callback_data["object"]["id"])
                            ->setAmount($data->amount)
                            ->setCurrency($data->operation->currency_code)
                            ->setReceiptItems(array(
                                array(
                                    'description' => $data->order_id,
                                    'quantity' => $data->item->count . '.00',
                                    'amount' => array(
                                        'value' => $data->item->price,
                                        'currency' => $data->operation->currency_code,
                                    ),
                                    'vat_code' => $this->data->params->vat,
                                    'payment_mode' => 'full_payment',
                                    'payment_subject' => 'payment',
                                ),
                            ))
                            ->setReceiptEmail($data->operation->data["user_email"])
                            ->setTaxSystemCode($this->data->params->tax);

            }else{

                $refundBuilder
                            ->setPaymentId($data->operation->callback_data["object"]["id"])
                            ->setAmount($data->amount)
                            ->setCurrency($data->operation->currency_code);

            }

            $request = $refundBuilder->build();

            $idempotenceKey = uniqid('', true);
            $response = $client->createRefund($request, $idempotenceKey);

            $refund = $response->getStatus();

            if($refund == "succeeded"){
                $app->model->transactions_operations->update(["status_processing"=>"refund","refund_data"=>$refund ? encrypt(_json_encode($refund)) : null], ["order_id=?", [$data->order_id]]);
            }else{
                $app->model->transactions_operations->update(["status_processing"=>"error","refund_data"=>$refund ? encrypt(_json_encode($refund)) : null], ["order_id=?", [$data->order_id]]);
            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
        }

    }

    public function callback($action=null){
        global $app;

        $requestBody = _json_decode(file_get_contents('php://input'));

        if($requestBody){

            try {

                $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
                        ? new NotificationSucceeded($requestBody)
                        : new NotificationWaitingForCapture($requestBody);

                $payment = $notification->getObject();

                if($payment->getStatus() === PaymentStatus::SUCCEEDED) {

                    $order = $app->component->transaction->getOperation($payment->metadata->order_id);

                    if($order){
                        $app->component->transaction->callback($order->data, _json_encode($requestBody));
                        header("HTTP/1.1 200 OK");
                    }else{
                        logger("Error payment not found order:".$payment->metadata->order_id);
                        header("HTTP/1.1 404 ERROR");
                    }

                }

            } catch (Exception $e) {
                logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
                header("HTTP/1.1 404 ERROR");
            }

        }

    }

    public function fieldsForm($params=[]){
        global $app;

        $secure_deal_available = '';
        $secure_deal_status = '';

        if($this->data->secure_deal_available){

            $secure_deal_available = '

                <h3 class="mt-3" >'.translate("tr_1eb027fdbd155cb5c39d813737a8318f").'</h3>

                <div class="col-12">

                  <label class="form-label mb-2" >'.translate("tr_39638dcb384d3f96f6cf2ab55236e85e").'</label>

                  <input type="text" name="type_score_name" class="form-control" value="'.$this->data->type_score_name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_62b685c7d7c78ac9b69b36cfc70c566f").'</label>

                  <textarea name="secure_description" class="form-control" >'.$this->data->secure_description.'</textarea>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_4c9b813328913ee49b0cf7b9f329c335").'</label>

                  <div class="input-group">
                    <input type="number" class="form-control" name="secure_deal_min_amount" value="'.$this->data->secure_deal_min_amount.'" />
                    <span class="input-group-text">'.$app->system->getDefaultCurrency()->symbol.'</span>
                  </div>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_7efac46fd7c18bde256303c3c21d398e").'</label>

                  <div class="input-group">
                    <input type="number" class="form-control" name="secure_deal_max_amount" value="'.$this->data->secure_deal_max_amount.'" />
                    <span class="input-group-text">'.$app->system->getDefaultCurrency()->symbol.'</span>
                  </div>

                </div>
            ';

            $secure_deal_status = '
                <div class="col-12 mt-2">

                    <label class="switch">
                      <input type="checkbox" name="secure_deal_status" value="1" class="switch-input" '.($this->data->secure_deal_status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_c21b2ddff1f121219f81a576c5f6a242").'</span>
                    </label>

                </div>
            ';

        }

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

                '.$secure_deal_status.'

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

                    <label class="switch">
                      <input type="checkbox" name="params[receipt]" value="1" class="switch-input integration-payment-services-edit-receipt-switch" '.($this->data->params->receipt ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87e8dd3eac313bc2e7f73640d0755300").'</span>
                    </label>

                </div>

                <div class="integration-payment-services-edit-receipt-container" '.($this->data->params->receipt ? 'style="display: block;"' : 'style="display: none;"').' >

                    <div class="col-12 mt-3">

                        <div>

                          <label class="form-label mb-2" >'.translate("tr_6aa03bc8477412d9d4fec0d3aa2f0a00").'</label>

                          <select class="form-select selectpicker" name="params[tax]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="1" '.($this->data->params->tax == 1 ? 'selected=""' : '').' >'.translate("tr_31f33f3abe036acb73740e38aa428b96").'</option>
                            <option value="2" '.($this->data->params->tax == 2 ? 'selected=""' : '').' >'.translate("tr_c312eec9bc05d4ca36b8c0b97d6361f8").'</option>
                            <option value="3" '.($this->data->params->tax == 3 ? 'selected=""' : '').' >'.translate("tr_10a32a52ec8ef4dba251e40f5c085bc8").'</option>
                            <option value="4" '.($this->data->params->tax == 4 ? 'selected=""' : '').' >'.translate("tr_ee3890b3cc52e05d98faeceaae55f0d3").'</option>
                            <option value="5" '.($this->data->params->tax == 5 ? 'selected=""' : '').' >'.translate("tr_d543313331865a30387343d27aa8f40c").'</option>
                            <option value="6" '.($this->data->params->tax == 6 ? 'selected=""' : '').' >'.translate("tr_e032aa607069a6d8c81f8ff43481ca41").'</option>
                          </select>

                        </div>

                        <div class="mt-3">

                          <label class="form-label mb-2" >'.translate("tr_343abee101c00ff5fc746fc7dba664d3").'</label>

                          <select class="form-select selectpicker" name="params[vat]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="1" '.($this->data->params->vat == 1 ? 'selected=""' : '').' >'.translate("tr_976ce0e8aa4277c8cbfa375771130a93").'</option>
                            <option value="2" '.($this->data->params->vat == 2 ? 'selected=""' : '').' >'.translate("tr_a9b8d0f446d92e45592cfe10b06a5ad3").'</option>
                            <option value="3" '.($this->data->params->vat == 3 ? 'selected=""' : '').' >'.translate("tr_b3ffe5e5d2f93b8f075b8eda1f7abc2e").'</option>
                            <option value="4" '.($this->data->params->vat == 4 ? 'selected=""' : '').' >'.translate("tr_513186c07238e50793ef398018c85c32").'</option>
                            <option value="5" '.($this->data->params->vat == 5 ? 'selected=""' : '').' >'.translate("tr_e3391a3446bbe6302195ddc1483ba8c7").'</option>
                            <option value="6" '.($this->data->params->vat == 6 ? 'selected=""' : '').' >'.translate("tr_4e782b7d5f1e9bcef1d1d543a86f45f6").'</option>
                          </select>

                        </div>

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

                  <label class="form-label mb-2" >'.translate("tr_b3feb860f372061e8afadfa082b3ccd7").'</label>

                  <input type="text" name="params[id]" class="form-control" value="'.$this->data->params->id.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_a09a7a6e949aab436f7b4bcd16ea8379").'</label>

                  <input type="text" name="params[key]" class="form-control" value="'.$this->data->params->key.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cf55d9a902b71b917a6f0f8aedd4ed11").'</label>

                  <select class="form-select selectpicker" name="params[currency]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                    <option value="RUB" '.($this->data->params->currency == "RUB" ? 'selected=""' : '').' >RUB</option>
                    <option value="USD" '.($this->data->params->currency == "USD" ? 'selected=""' : '').' >USD</option>
                    <option value="EUR" '.($this->data->params->currency == "EUR" ? 'selected=""' : '').' >EUR</option>
                    <option value="UAH" '.($this->data->params->currency == "UAH" ? 'selected=""' : '').' >UAH</option>
                    <option value="KZT" '.($this->data->params->currency == "KZT" ? 'selected=""' : '').' >KZT</option>
                    <option value="CNY" '.($this->data->params->currency == "CNY" ? 'selected=""' : '').' >CNY</option>
                  </select>

                </div>

                '.$secure_deal_available.'

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </from>
        ';

    }


}