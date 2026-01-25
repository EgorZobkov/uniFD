<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Unitpay
{
    public $alias = "unitpay";
    public $data;

    public function __construct()
    {
        global $app;
        $this->data = $this->getData();
    }

    public function getData()
    {
        global $app;
        $data = $app->model->system_payment_services->find("alias=?", [$this->alias]);
        if ($data) {
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
        return 'data:image/png;base64,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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params = [])
    {
        global $app;

        try {
            $publicKey = $this->data->params->public_key;
            $projectId = $this->data->params->project_id;
            $currency = $app->system->getDefaultCurrency()->code;
            $amount = numberFormat($params["amount"], 2, ".", "");
            $orderId = $params["order_id"];
            $description = urlencode(trim($params["title"]));
            $secretKey = $this->data->params->secret_key;

            $result = _json_decode(_file_get_contents("https://unitpay.ru/api?method=initPayment&params[paymentType]=card&params[projectId]=".$projectId."&params[secretKey]=".$secretKey."&params[sum]=".$amount."&params[desc]=".$description."&params[account]=".$orderId));
            
            if($result["result"]["redirectUrl"]){
                return ["link" => $result["result"]["redirectUrl"]];
            }else{
                logger("Payment " . $this->alias . " createPayment error: ".print_r($result, true));
            }
            
        } catch (\Exception $e) {
            logger("Payment " . $this->alias . " createPayment error: {$e->getMessage()}");
        }
    }

    public function createPayout($data = [])
    {
        global $app;

        try {

            $url = "https://unitpay.ru/api?method=massPayment&params[projectId]=".$this->data->params->projectId."&params[sum]=".round($data["amount"], 2)."&params[purse]=".$data["payment_data"]["score"]."&params[login]=".$this->data->params->login."&params[transactionId]=".$data["order_id"]."&params[secretKey]=".$this->data->params->api_key."&params[paymentType]=card";

            $response = _json_decode(_file_get_contents($url));

            if (isset($response["result"]["status"]) && $response["result"]["status"] == 'success') {
                $app->model->transactions_deals_payments->update(
                    ["comment" => null, "status_processing" => "done"], 
                    $data["id"]
                );
            } else {
                $app->model->transactions_deals_payments->update(
                    ["comment" => "{$response["error"]["code"]}, {$response["error"]["message"]}", "status_processing" => "payment_error", "user_show_error" => 0],
                    $data["id"]
                );
            }

        } catch (\Exception $e) {
            logger("Payment " . $this->alias . " createPayout error: {$e->getMessage()}");
        }
    }

    public function createRefund($data = [])
    {
        global $app;

        try {

            $url = "https://unitpay.ru/api?method=refundPayment&params[paymentId]=".$data->operation->callback_data["unitpayId"]."&params[secretKey]=".$this->data->params->secret_key."&params[sum]=".round($data->amount,2);

            $response = _json_decode(_file_get_contents($url));

            if($response["result"]){
                $app->model->transactions_operations->update(["status_processing"=>"refund","refund_data"=>$refund ? encrypt(_json_encode($result)) : null], ["order_id=?", [$data->order_id]]);
            }else{
                $app->model->transactions_operations->update(["status_processing"=>"error","refund_data"=>$refund ? encrypt(_json_encode($result)) : null], ["order_id=?", [$data->order_id]]);
            }

        } catch (\Exception $e) {
            logger("Payment " . $this->alias . " createRefund error: {$e->getMessage()}");
        }
    }

    public function callback($action = null)
    {
        global $app;

        try {
            if (isset($_GET['method']) && isset($_GET['params'])) {
                $method = $_GET['method'];
                $params = $_GET['params'];
                $secretKey = $this->data->params->secret_key;

                $signature = $params['signature'];
                unset($params['signature']);
                ksort($params);
                $hashStr = $method . '{up}' . implode('{up}', $params);
                $controlSignature = hash('sha256', $hashStr . '{up}' . $secretKey);

                if ($controlSignature !== $signature) {
                    header("HTTP/1.1 403 Forbidden");
                    echo json_encode(['error' => 'Invalid signature']);
                    exit;
                }

                if ($method === 'pay') {
                    $order = $app->component->transaction->getOperation($params['account']);
                    if ($order) {
                        $app->component->transaction->callback($order->data, _json_encode($params));
                        echo json_encode(['result' => ['message' => 'OK']]);
                        exit;
                    } else {
                        logger("Unitpay payment error: Order not found - {$params['account']}");
                        header("HTTP/1.1 404 Not Found");
                    }
                } else {
                    echo json_encode(['result' => ['message' => 'OK']]);
                    exit;
                }
            } else {
                header("HTTP/1.1 400 Bad Request");
            }
        } catch (\Exception $e) {
            logger("Payment " . $this->alias . " callback error: {$e->getMessage()}");
            header("HTTP/1.1 500 Internal Server Error");
        }
    }

    public function fieldsForm($params = [])
    {
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
        <form class="integrationPaymentForm">
            <h3>' . $this->data->name . '</h3>
            <div class="row">

                <div class="col-12">
                    <label class="switch">
                      <input type="checkbox" name="status" value="1" class="switch-input" ' . ($this->data->status ? 'checked=""' : '') . '>
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">' . translate("tr_87a4286b7b9bf700423b9277ab24c5f1") . '</span>
                    </label>
                </div>

                '.$secure_deal_status.'

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">' . translate("tr_55c9488fbbf51f974a38acd8ccb87ee1") . '</label>
                  ' . $app->ui->managerFiles(["filename" => $this->data->image, "type" => "images", "path" => "images"]) . '
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-1">' . translate("tr_673b49f1887ca36b7e1d37d4f8c112b9") . '</label>
                  <strong>' . $app->system->buildWebhook("payment", $this->alias) . '</strong>
                  <div class="alert alert-warning d-flex align-items-center mt-2 mb-0" role="alert">
                    ' . translate("tr_d6049d9c844a6dfea6051bfe3f0d7462") . '
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
                  <label class="form-label mb-2">Public Key</label>
                  <input type="text" name="params[public_key]" class="form-control" value="' . ($this->data->params->public_key ?? '') . '" />
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">Secret Key</label>
                  <input type="text" name="params[secret_key]" class="form-control" value="' . ($this->data->params->secret_key ?? '') . '" />
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">Project ID</label>
                  <input type="text" name="params[project_id]" class="form-control" value="' . ($this->data->params->project_id ?? '') . '" />
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">Api Key ('.translate("tr_196523cc6830f9745b1e306d4703b9d3").')</label>
                  <input type="text" name="params[api_key]" class="form-control" value="' . ($this->data->params->api_key ?? '') . '" />
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-2">Email account ('.translate("tr_196523cc6830f9745b1e306d4703b9d3").')</label>
                  <input type="text" name="params[login]" class="form-control" value="' . ($this->data->params->login ?? '') . '" />
                </div>

                '.$secure_deal_available.'

                <input type="hidden" name="id" value="' . $this->data->id . '" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationPaymentSave">' . translate("tr_74ea58b6a801f0dce4e5d34dbca034dc") . '</button>
                </div>
            </div>
        </form>
        ';
    }
}

?>