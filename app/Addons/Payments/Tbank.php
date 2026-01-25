<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Tbank{

    public $alias = "tbank";
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
        return 'data:image/png;base64,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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function buildItems($items, $amount){

        $sum = 0;

        foreach ($items as $item) {
            $sum += $item['Amount'];
        }

        if ($sum != $amount) {
            $sumAmountNew = 0;
            $difference = $amount - $sum;
            $amountNews = [];

            foreach ($items as $key => $item) {
                $itemsAmountNew = $item['Amount'] + floor($difference * $item['Amount'] / $sum);
                $amountNews[$key] = $itemsAmountNew;
                $sumAmountNew += $itemsAmountNew;
            }

            if ($sumAmountNew != $amount) {
                $max_key = array_keys($amountNews, max($amountNews))[0];
                $amountNews[$max_key] = max($amountNews) + ($amount - $sumAmountNew);
            }

            foreach ($amountNews as $key => $item) {
                $items[$key]['Amount'] = $amountNews[$key];
            }
        }

        return $items;
    }

    public function createPayment($params=[]){
        global $app;

        try {

            $api = new MerchantAPI(
                $this->data->params->terminal_key,
                htmlspecialchars_decode($this->data->params->secret_key)
            );

            $params["amount"] = $params["amount"] * 100;

            $paramsData = [
                'OrderId' => $params["order_id"],
                'Amount'  => $params["amount"],
                'Description' => $params["title"],
                'NotificationURL' => $app->system->buildWebhook("payment", $this->alias),
                'SuccessURL' => getHost(true) . "/payment/status/order/" . $params["order_id"],
                'FailURL' => getHost(true) . "/payment/status/order/" . $params["order_id"],
                'DATA'    => [
                    'Email' => $params["user_email"]
                ],
            ];

            if($this->data->params->receipt){

                $receiptItem = [[
                    'Name'          => $params["title"],
                    'Price'         => $params["amount"],
                    'Quantity'      => 1,
                    'Amount'        => $params["amount"],
                    'PaymentMethod' => 'full_payment',
                    'PaymentObject' => 'payment',
                    'Tax'           => $this->data->params->vat ?: 'none',
                ]];

                $receipt = [
                    'Email'        => $params["user_email"],
                    'Phone'        => $params["user_phone"],
                    'Taxation'     => $this->data->params->tax,
                    'Items'        => $this->buildItems($receiptItem, $params["amount"]),
                ];

                $paramsData['Receipt'] = $receipt;
            }

            $init = $api->init($paramsData);

            if($api->paymentUrl){
                return ["link"=>$api->paymentUrl];
            }else{
                logger("Payment ".$this->alias." createPayment error: {$api->response}");
            }

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
        }

    }

    public function createPayout($data=[]){
        global $app;

        try {

            $api = new PaymentsAPI(
                $this->data->params->payout_terminal_key,
                htmlspecialchars_decode($this->data->params->payout_secret_key)
            );   

            $result = $api->payment($data["order_id"], $data["payment_data"]["card_id"], round($data["amount"],2));

            if($result['status']){
                $app->model->transactions_deals_payments->update(["comment"=>null, "status_processing"=>"done"], $data["id"]);
            }else{
                $app->model->transactions_deals_payments->update(["comment"=>$result['answer'], "status_processing"=>"payment_error", "user_show_error"=>0], $data["id"]);
            }

            return $result;

        } catch (Exception $e) {
            logger("Payment ".$this->alias." createPayout error: {$e->getMessage()}");
        }

    }

    public function createRefund($data=[]){
        global $app;

        try {

            $api = new MerchantAPI(
                $this->data->params->terminal_key,
                htmlspecialchars_decode($this->data->params->secret_key)
            );   

            $result = $api->cancel(["PaymentId"=>$data->operation->callback_data["PaymentId"], "Amount"=>round($data->amount,2)]);

            if($result['Success'] == true){
                $app->model->transactions_operations->update(["status_processing"=>"refund","refund_data"=>$result ? encrypt(_json_encode($result)) : null], ["order_id=?", [$data->order_id]]);
                return ['status' => true];
            }else{
                $app->model->transactions_operations->update(["status_processing"=>"error","refund_data"=>$result ? encrypt(_json_encode($result)) : null], ["order_id=?", [$data->order_id]]);
                return ['status' => false, 'answer' => $result['Message'].$result['Details']];
            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
        }

    }

    public function addCard($params=[]){
        global $app;

        try {

            $api = new PaymentsAPI(
                $this->data->params->payout_terminal_key,
                htmlspecialchars_decode($this->data->params->payout_secret_key)
            );   

            $result = $api->addCard($params["user_id"]);

            return $result;

        } catch (Exception $e) {
            logger("Payment ".$this->alias." addCard error: {$e->getMessage()}");
        }

    }

    public function deleteCard($params=[]){
        global $app;

        try {

            $api = new PaymentsAPI(
                $this->data->params->payout_terminal_key,
                htmlspecialchars_decode($this->data->params->payout_secret_key)
            );   

            $result = $api->deleteCard($params["user_id"], $params["card_id"]);

            return $result;

        } catch (Exception $e) {
            logger("Payment ".$this->alias." deleteCard error: {$e->getMessage()}");
        }

    }

    public function genToken($args){
        global $param;
        $token = '';

        unset($args['Token']);
        $args['Success'] = $args['Success'] ? 'true' : 'false';
        $args['Password'] = htmlspecialchars_decode($this->data->params->secret_key);
        ksort($args);

        foreach ($args as $key => $arg) {
            if (!is_array($arg)) {
                $token .= $arg;
            }
        }

        $token = hash('sha256', $token);

        return $token;
    }

    public function callback($action=null){
        global $app;

        $requestBody = _json_decode(file_get_contents('php://input'));

        if(!$requestBody){
            logger("Payment ".$this->alias." callback error: Empty data");
            header("HTTP/1.1 404 ERROR");            
        }

        try {

            if($requestBody["CardId"]){

                $customer = explode('client_', $requestBody['CustomerKey']);

                if(($requestBody['Success'] == true || $requestBody['Success'] == 'true') && $requestBody['Status'] == 'COMPLETED' && intval($customer[1])){

                    $app->model->users_payment_data->insert(["card_id"=>$requestBody['CardId'], "score"=>$requestBody['Pan'], "user_id"=>intval($customer[1]), "default_status"=>1, "type_score"=>"add_card"]);

                    header("HTTP/1.1 200 OK");

                }

            }else{

                $token = $this->genToken($requestBody);

                if ($token == $requestBody['Token']) {

                    if ($requestBody['Status'] == 'CONFIRMED') {

                        $order = $app->component->transaction->getOperation($requestBody['OrderId']);

                        if($order){
                            $app->component->transaction->callback($order->data, _json_encode($requestBody));
                            header("HTTP/1.1 200 OK");
                        }else{
                            logger("Payment ".$this->alias." callback error: not found order");
                            header("HTTP/1.1 404 ERROR");
                        }

                    }

                }

            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
            header("HTTP/1.1 404 ERROR");
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

                  <label class="form-label mb-2" >'.translate("tr_590ba598f5ab9676885a6bcc0e9a98ef").'</label>

                  <input type="text" name="params[payout_terminal_key]" class="form-control" value="'.$this->data->params->payout_terminal_key.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_accbe881c8aeb5f0bdb77fd3faec721d").'</label>

                  <input type="text" name="params[payout_secret_key]" class="form-control" value="'.$this->data->params->payout_secret_key.'" />

                </div>

                <div class="col-12 mt-3">

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

                        <div class="mt-2">

                          <label class="form-label mb-2" >'.translate("tr_6aa03bc8477412d9d4fec0d3aa2f0a00").'</label>

                          <select class="form-select selectpicker" name="params[tax]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="osn" '.($this->data->params->tax == "osn" ? 'selected=""' : '').' >'.translate("tr_31f33f3abe036acb73740e38aa428b96").'</option>
                            <option value="usn_income" '.($this->data->params->tax == "usn_income" ? 'selected=""' : '').' >'.translate("tr_c312eec9bc05d4ca36b8c0b97d6361f8").'</option>
                            <option value="usn_income_outcome" '.($this->data->params->tax == "usn_income_outcome" ? 'selected=""' : '').' >'.translate("tr_10a32a52ec8ef4dba251e40f5c085bc8").'</option>
                            <option value="envd" '.($this->data->params->tax == "envd" ? 'selected=""' : '').' >'.translate("tr_ee3890b3cc52e05d98faeceaae55f0d3").'</option>
                            <option value="esn" '.($this->data->params->tax == "esn" ? 'selected=""' : '').' >'.translate("tr_d543313331865a30387343d27aa8f40c").'</option>
                            <option value="patent" '.($this->data->params->tax == "patent" ? 'selected=""' : '').' >'.translate("tr_e032aa607069a6d8c81f8ff43481ca41").'</option>
                          </select>

                        </div>

                        <div class="mt-3">

                          <label class="form-label mb-2" >'.translate("tr_343abee101c00ff5fc746fc7dba664d3").'</label>

                          <select class="form-select selectpicker" name="params[vat]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                            <option value="none" '.($this->data->params->vat == "none" ? 'selected=""' : '').' >'.translate("tr_976ce0e8aa4277c8cbfa375771130a93").'</option>
                            <option value="vat0" '.($this->data->params->vat == "vat0" ? 'selected=""' : '').' >'.translate("tr_a9b8d0f446d92e45592cfe10b06a5ad3").'</option>
                            <option value="vat10" '.($this->data->params->vat == "vat10" ? 'selected=""' : '').' >'.translate("tr_6a4c28b9112b0dce6be7b83e4f9de4e5").'</option>
                            <option value="vat20" '.($this->data->params->vat == "vat20" ? 'selected=""' : '').' >'.translate("tr_d1f95bf15a4d38e3416bb39c417099b2").'</option>
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

                  <label class="form-label mb-2" >'.translate("tr_013eb422c853ea22ae158e4c9cf0641e").'</label>

                  <input type="text" name="params[terminal_key]" class="form-control" value="'.$this->data->params->terminal_key.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_88042a417ef1da769152d2b029bb7a23").'</label>

                  <input type="text" name="params[secret_key]" class="form-control" value="'.$this->data->params->secret_key.'" />

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

class MerchantAPI
{
    private $api_url;
    private $terminalKey;
    private $secretKey;
    private $paymentId;
    private $status;
    private $error;
    private $response;
    private $paymentUrl;


    public function __construct($terminalKey, $secretKey)
    {
        $this->api_url = 'https://securepay.tinkoff.ru/v2/';
        $this->terminalKey = $terminalKey;
        $this->secretKey = $secretKey;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'paymentId':
                return $this->paymentId;
            case 'status':
                return $this->status;
            case 'error':
                return $this->error;
            case 'paymentUrl':
                return $this->paymentUrl;
            case 'response':
                return htmlentities($this->response);
            default:
                if ($this->response) {
                    if ($json = json_decode($this->response, true)) {
                        foreach ($json as $key => $value) {
                            if (strtolower($name) == strtolower($key)) {
                                return $json[$key];
                            }
                        }
                    }
                }

                return false;
        }
    }

    /**
     * @param $args mixed You could use associative array or url params string
     * @return bool
     * @throws HttpException
     */
    public function init($args)
    {
        return $this->buildQuery('Init', $args);
    }


    public function getState($args)
    {
        return $this->buildQuery('GetState', $args);
    }

    public function confirm($args)
    {
        return $this->buildQuery('Confirm', $args);
    }

    public function charge($args)
    {
        return $this->buildQuery('Charge', $args);
    }

    public function addCustomer($args)
    {
        return $this->buildQuery('AddCustomer', $args);
    }

    public function getCustomer($args)
    {
        return $this->buildQuery('GetCustomer', $args);
    }

    public function removeCustomer($args)
    {
        return $this->buildQuery('RemoveCustomer', $args);
    }

    public function getCardList($args)
    {
        return $this->buildQuery('GetCardList', $args);
    }

    public function removeCard($args)
    {
        return $this->buildQuery('RemoveCard', $args);
    }

    public function cancel($args)
    {
        return $this->buildQuery('Cancel', $args);
    }

    /**
     * Builds a query string and call sendRequest method.
     * Could be used to custom API call method.
     *
     * @param string $path API method name
     * @param mixed $args query params
     *
     * @return mixed
     * @throws HttpException
     */
    public function buildQuery($path, $args)
    {
        $url = $this->api_url;
        if (is_array($args)) {
            if (!array_key_exists('TerminalKey', $args)) {
                $args['TerminalKey'] = $this->terminalKey;
            }
            if (!array_key_exists('Token', $args)) {
                $args['Token'] = $this->genToken($args);
            }
        }
        $url = $this->combineUrl($url, $path);
        return $this->sendRequest($url, $args);
    }

    /**
     * Generates Token
     *
     * @param $args
     * @return string
     */
    private function genToken($args)
    {
        $token = '';
        $args['Password'] = $this->secretKey;
        ksort($args);

        foreach ($args as $arg) {
            if (!is_array($arg)) {
                $token .= $arg;
            }
        }
        $token = hash('sha256', $token);

        return $token;
    }

    /**
     * Combines parts of URL. Simply gets all parameters and puts '/' between
     *
     * @return string
     */
    private function combineUrl()
    {
        $args = func_get_args();
        $url = '';
        foreach ($args as $arg) {
            if (is_string($arg)) {
                if ($arg[strlen($arg) - 1] !== '/') $arg .= '/';
                $url .= $arg;
            } else {
                continue;
            }
        }

        return $url;
    }

    /**
     * Main method. Call API with params
     *
     * @param $api_url
     * @param $args
     * @return bool|string
     * @throws HttpException
     */
    private function sendRequest($api_url, $args)
    {
        $this->error = '';
        if (is_array($args)) {
            $args = json_encode($args);
        }

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));

            $out = curl_exec($curl);
            $this->response = $out;
            $json = json_decode($out);

            if ($json) {
                if (@$json->ErrorCode !== "0") {
                    $this->error = @$json->Details;
                } else {
                    $this->paymentUrl = @$json->PaymentURL;
                    $this->paymentId = @$json->PaymentId;
                    $this->status = @$json->Status;
                }
            }

            curl_close($curl);

            return $out;

        } else {
            throw new HttpException('Can not create connection to ' . $api_url . ' with args ' . $args, 404);
        }
    }
}

class PaymentsAPI
{
    public $apiUrl;
    public $terminalKey;
    public $secretKey;

    public function __construct($terminalKey, $secretKey)
    {
        $this->apiUrl = 'https://securepay.tinkoff.ru/e2c/v2/';
        $this->terminalKey = $terminalKey;
        $this->secretKey = $secretKey;
    }

    public function sendRequest($api_url, $args)
    {

        if (is_array($args)) {
            $args = json_encode($args);
        }

        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $args);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            ));

            $out = curl_exec($curl);
            $json = json_decode($out, true);

            curl_close($curl);

            return $json;

        } else {
            throw new HttpException('Can not create connection to ' . $api_url . ' with args ' . $args, 404);
        }
    }

    public function toSha256($args)
    {
        $token = '';
        ksort($args);

        foreach ($args as $key => $arg) {
            $token .= $arg;
        }

        $token = hash('sha256', $token);

        return $token;
    }

    public function buildSignature($params=[]){

        $sha256 = $this->toSha256($params);

        return [
            'Token' => $sha256,
        ];

    }

    public function addCard($userId, $cardId=null){

        $params = [
            'TerminalKey' => $this->terminalKey,
            'CustomerKey'  => 'client_'.$userId,
            'Password' => $this->secretKey,
        ];

        $output = array_merge($params, $this->buildSignature($params));

        if($cardId){

            $result = $this->sendRequest($this->apiUrl.'AddCard', $output);

            if($result['Success'] == true){
                return ['status' => true, 'link' => $result['PaymentURL']];
            }else{
                return ['status' => false, 'answer' => $result['Message'].$result['Details']];
            }

        }

        $result = $this->sendRequest($this->apiUrl.'AddCustomer', $output);

        if($result['Success'] == true){

            $result = [];

            $result = $this->sendRequest($this->apiUrl.'AddCard', $output);

            if($result['Success'] == true){
                return ['status' => true, 'link' => $result['PaymentURL']];
            }else{
                return ['status' => false, 'answer' => $result['Message'].$result['Details']];
            }

        }else{

            $result = $this->sendRequest($this->apiUrl.'AddCard', $output);

            if($result['Success'] == true){
                return ['status' => true, 'link' => $result['PaymentURL']];
            }else{
                return ['status' => false, 'answer' => $result['Message'].$result['Details']];
            }

        }

    }

    public function deleteCard($userId, $cardId){

        $params = [
            'TerminalKey' => $this->terminalKey,
            'CardId' => (int)$cardId,
            'CustomerKey'  => 'client_'.$userId,
            'Password' => $this->secretKey,
        ];

        $output = array_merge($params, $this->buildSignature($params));

        $result = $this->sendRequest($this->apiUrl.'RemoveCard', $output);  
        
        if($result['Success'] == true){
            return ['status' => true];
        }else{
            return ['status' => false, 'answer' => $result['Message'].$result['Details']];
        }

    }

    public function payment($orderId, $cardId, $amount){

        $params = [
           'TerminalKey' => $this->terminalKey,
           'OrderId' => (String)$orderId,
           'CardId' => (int)$cardId,
           'Amount' => $amount * 100,
           'Password' => $this->secretKey,
        ];

        $output = array_merge($params, $this->buildSignature($params));

        $result = $this->sendRequest($this->apiUrl.'Init', $output);

        if ($result['Success'] == "true"){

              $params = [];
              $output = [];

              $params = [
                 'TerminalKey' => $this->terminalKey,
                 'Password' => $this->secretKey,
                 'PaymentId' => $result['PaymentId'],
              ];

              $output = array_merge($params, $this->buildSignature($params));
     
              $result = $this->sendRequest($this->apiUrl.'Payment', $output);  

              if($result['Success'] == "true"){

                 return ['status' => true]; 

             }else{
                return ['status' => false, 'answer' => $result['Message'].$result['Details']];
             }

        }else{
            return ['status' => false, 'answer' => $result['Message'].$result['Details']];
        }

    }


}