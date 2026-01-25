<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

use App\Systems\Logger;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;

class PayPal {

    public $alias = "paypal";
    public $data;

    public function __construct() {
        global $app;
        $this->data = $this->getData();
    }

    public function getData() {
        global $app;
        $data = $app->model->system_payment_services->find("alias=?", [$this->alias]);
        if($data) {
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAgAAAAJcCAYAAACPNBx2AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDoxRDg3RUE0QjM5MkYxMUYwODE5OTlBQUJCNDgxMjZEMSIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDoxRDg3RUE0QzM5MkYxMUYwODE5OTlBQUJCNDgxMjZEMSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjFEODdFQTQ5MzkyRjExRjA4MTk5OUFBQkI0ODEyNkQxIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjFEODdFQTRBMzkyRjExRjA4MTk5OUFBQkI0ODEyNkQxIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+ISp/iQAAWvJJREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    private function getClient() {
        $clientId = $this->data->params->client_id;
        $clientSecret = $this->data->params->secret_key;
        
        if($this->data->params->sandbox) {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        } else {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        }
        
        return new PayPalHttpClient($environment);
    }

    public function createPayment($params = []) {
        global $app;

        $client = $this->getClient();
        
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "reference_id" => $params["order_id"],
                    "amount" => [
                        "value" => numberFormat($params["amount"], 2, ".", ""),
                        "currency_code" => $this->data->params->currency
                    ],
                    "description" => $params["title"]
                ]
            ],
            "application_context" => [
                "return_url" => getHost(true) . "/payment/status/order/" . $params["order_id"],
                "cancel_url" => getHost(true) . "/payment/cancel/order/" . $params["order_id"]
            ]
        ];

        try {
            $response = $client->execute($request);
            $approvalUrl = null;
            
            foreach($response->result->links as $link) {
                if($link->rel == 'approve') {
                    $approvalUrl = $link->href;
                    break;
                }
            }

            return ["link" => $approvalUrl];

        } catch (\Exception $e) {
            Logger::set("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
            return null;
        }
    }

    public function capturePayment($paymentId) {
        $client = $this->getClient();
        $request = new OrdersCaptureRequest($paymentId);
        
        try {
            $response = $client->execute($request);
            return $response->result;
        } catch (\Exception $e) {
            Logger::set("Payment ".$this->alias." capturePayment error: {$e->getMessage()}");
            return null;
        }
    }

    public function createRefund($data = []) {
        global $app;
        
        $client = $this->getClient();
        $request = new CapturesRefundRequest($data->operation->callback_data["capture_id"]);
        
        $request->body = [
            "amount" => [
                "value" => numberFormat($data->amount, 2, ".", ""),
                "currency_code" => $data->operation->currency_code
            ],
            "note_to_payer" => "Refund for order #".$data->order_id
        ];

        try {
            $response = $client->execute($request);
            
            if($response->result->status == "COMPLETED") {
                $app->model->transactions_operations->update([
                    "status_processing" => "refund",
                    "refund_data" => encrypt(_json_encode($response->result))
                ], ["order_id=?", [$data->order_id]]);
            } else {
                $app->model->transactions_operations->update([
                    "status_processing" => "error",
                    "refund_data" => encrypt(_json_encode($response->result))
                ], ["order_id=?", [$data->order_id]]);
            }

        } catch (\Exception $e) {
            Logger::set("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
        }
    }

    public function callback() {
        global $app;

        $webhookContent = file_get_contents('php://input');
        $webhookEvent = _json_decode($webhookContent);
        
        try {
            if($webhookEvent->event_type == "PAYMENT.CAPTURE.COMPLETED") {
                $orderId = $webhookEvent->resource->custom_id ?? null;
                
                if($orderId) {
                    $order = $app->component->transaction->getOperation($orderId);
                    
                    if($order) {
                        $app->component->transaction->callback($order->data, $webhookContent);
                        http_response_code(200);
                        return;
                    }
                }
            }
            
            http_response_code(404);
            
        } catch (\Exception $e) {
            Logger::set("Payment ".$this->alias." callback error: {$e->getMessage()}");
            http_response_code(500);
        }
    }

    public function fieldsForm($params = []) {
        global $app;

        return '
        <form class="integrationPaymentForm">
            <h3>'.$this->data->name.'</h3>
            <div class="row">
                <div class="col-12">
                    <label class="switch">
                      <input type="checkbox" name="status" class="switch-input" value="1" '.($this->data->status ? 'checked' : '').'>
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87a4286b7b9bf700423b9277ab24c5f1").'</span>
                    </label>
                </div>

                <div class="col-12 mt-2">
                    <label class="switch">
                      <input type="checkbox" name="params[sandbox]" value="1" class="switch-input" '.($this->data->params->sandbox ?? '' ? 'checked' : '').'>
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
                  <label class="form-label mb-1">Webhook URL</label>
                  <strong>'.$app->system->buildWebhook("payment", $this->alias).'</strong>
                  <div class="alert alert-warning mt-2 mb-0">
                    '.translate("tr_3981cbef1743ee74a7a52660074cd1c5").'
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
                  <label class="form-label mb-2">Client ID</label>
                  <input type="text" name="params[client_id]" class="form-control" value="'.$this->data->params->client_id.'">
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">Secret Key</label>
                  <input type="text" name="params[secret_key]" class="form-control" value="'.$this->data->params->secret_key.'">
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">'.translate("tr_cf55d9a902b71b917a6f0f8aedd4ed11").'</label>
                  <select class="selectpicker" name="params[currency]">
                    <option value="USD" '.($this->data->params->currency == "USD" ? 'selected' : '').'>USD</option>
                    <option value="EUR" '.($this->data->params->currency == "EUR" ? 'selected' : '').'>EUR</option>
                    <option value="RUB" '.($this->data->params->currency == "RUB" ? 'selected' : '').'>RUB</option>
                  </select>
                </div>

                <input type="hidden" name="id" value="'.$this->data->id.'">

                <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>
            </div>
        </form>
        ';
    }
}