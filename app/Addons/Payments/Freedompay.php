<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Freedompay {

    public $alias = "freedompay";
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
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEnCAYAAABG253oAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpDMjhFOTNBODQ1RTMxMUYwOTYyMjhCNzk1MjgyMjhBNCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpDMjhFOTNBOTQ1RTMxMUYwOTYyMjhCNzk1MjgyMjhBNCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkMyOEU5M0E2NDVFMzExRjA5NjIyOEI3OTUyODIyOEE0IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkMyOEU5M0E3NDVFMzExRjA5NjIyOEI3OTUyODIyOEE0Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+J7lVtQAAHa1JREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params = []) {
        global $app;
        
        $merchantId = $this->data->params->merchant_id;
        $secretKey = $this->data->params->secret_key;
        $orderId = $params["order_id"];
        $amount = numberFormat($params["amount"], 2, '.', '');
        $currency = $this->data->params->currency ?? 'KZT';
        
        // Генерация подписи для FreedomPay KZ
        $signatureString = $merchantId . $orderId . $amount . $currency;
        $signature = hash_hmac('sha256', $signatureString, $secretKey);
        
        // Параметры для платежа (согласно API FreedomPay KZ)
        $requestData = [
            'merchant_id' => $merchantId,
            'order_id' => $orderId,
            'amount' => $amount,
            'currency' => $currency,
            'description' => $params["title"] ?? 'Payment',
            'success_url' => getHost(true) . "/payment/success/" . $this->alias,
            'failure_url' => getHost(true) . "/payment/failure/" . $this->alias,
            'callback_url' => getHost(true) . "/payment/callback/" . $this->alias,
            'signature' => $signature
        ];
        
        // URL API FreedomPay KZ
        $apiUrl = ($this->data->params->sandbox ?? false) 
            ? 'https://test.freedompay.kz/init_payment.php' 
            : 'https://api.freedompay.kz/init_payment.php';
            
        // Отправка запроса на создание платежа
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Обработка ответа
        $responseData = _json_decode($response);
        
        if($httpCode == 200 && isset($responseData['payment_url'])) {
            return ["link" => $responseData['payment_url']];
        } else {
            logger("FreedomPay KZ payment creation failed: " . print_r($responseData, true));
            return ["error" => $responseData['message'] ?? 'Payment creation failed'];
        }
    }

    public function callback() {
        global $app;

        // Получаем данные POST запроса
        $rawData = file_get_contents('php://input');
        $data = _json_decode($rawData);
        
        // Проверяем обязательные параметры
        if(empty($data['order_id']) || empty($data['status']) || empty($data['signature'])) {
            http_response_code(400);
            exit;
        }
        
        $secretKey = $this->data->params->secret_key;
        $orderId = $data['order_id'];
        
        // Формируем подпись для проверки (согласно API FreedomPay KZ)
        $signatureData = $data['transaction_id'] . $data['order_id'] . $data['amount'] . $data['currency'] . $data['status'];
        $expectedSignature = hash_hmac('sha256', $signatureData, $secretKey);
        
        // Проверка подписи
        if($expectedSignature !== $data['signature']) {
            logger("FreedomPay KZ: Invalid signature for order $orderId");
            http_response_code(403);
            exit;
        }
        
        // Обработка статуса платежа
        if($data['status'] === 'success') {
            $order = $app->component->transaction->getOperation($orderId);
            if($order) {
                $app->component->transaction->callback($order->data, $data);
                http_response_code(200);
            } else {
                logger("FreedomPay KZ: Order $orderId not found");
                http_response_code(404);
            }
        } else {
            logger("FreedomPay KZ: Payment failed for order $orderId. Status: ".$data['status']);
            http_response_code(200);
        }
    }

    public function createRefund($data = []) {
        global $app;
        
        $merchantId = $this->data->params->merchant_id;
        $secretKey = $this->data->params->secret_key;
        
        // Получаем исходную транзакцию
        $operation = $app->model->transactions_operations->find("order_id=?", [$data->order_id]);
        if(!$operation || !$operation->callback_data) {
            logger("FreedomPay KZ refund: operation not found for order ".$data->order_id);
            return;
        }
        
        // Декодируем данные транзакции
        $callbackData = _json_decode(decrypt($operation->callback_data));
        $transactionId = $callbackData['transaction_id'] ?? null;
        
        if(!$transactionId) {
            logger("FreedomPay KZ refund: transaction_id not found for order ".$data->order_id);
            return;
        }
        
        $refundId = uniqid('rf_');
        $amount = number_format($data->amount, 2, '.', '');
        
        // Генерация подписи для возврата
        $signatureData = $merchantId . $transactionId . $refundId . $amount;
        $signature = hash_hmac('sha256', $signatureData, $secretKey);
        
        // Подготовка запроса
        $url = ($this->data->params->sandbox ?? false)
            ? 'https://test.freedompay.kz/api/v1/refund'
            : 'https://freedompay.kz/api/v2/refund';
            
        $postData = [
            'merchant_id' => $merchantId,
            'transaction_id' => $transactionId,
            'refund_id' => $refundId,
            'amount' => $amount,
            'signature' => $signature
        ];
        
        // Отправка запроса
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Обработка ответа
        $result = _json_decode($response);
        if($httpCode == 200 && ($result['status'] ?? '') === 'success') {
            $app->model->transactions_operations->update([
                "status_processing" => "refund",
                "refund_data" => encrypt(_json_encode($result))
            ], ["order_id=?", [$data->order_id]]);
        } else {
            $app->model->transactions_operations->update([
                "status_processing" => "error",
                "refund_data" => encrypt(_json_encode($result))
            ], ["order_id=?", [$data->order_id]]);
            logger("FreedomPay KZ refund error: " . print_r($result, true));
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
                      <input type="checkbox" name="status" value="1" class="switch-input" '.($this->data->status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_87a4286b7b9bf700423b9277ab24c5f1").'</span>
                    </label>
                </div>

                <div class="col-12 mt-3">
                    <label class="switch">
                      <input type="checkbox" name="params[sandbox]" value="1" class="switch-input" '.($this->data->params->sandbox ?? '' ? 'checked' : '').'>
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">'.translate("tr_1c786b318c277415f9a01cb0e378152f").'</span>
                    </label>
                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-1">Callback URL</label>
                  <strong>'.$app->system->buildWebhook("payment", $this->alias).'</strong>
                  <div class="alert alert-warning mt-2 mb-0">
                    '.translate("tr_96c4ae22241a6bd6450418233ea49544").'
                  </div>
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-1">Success URL</label>
                  <strong>'.getHost(true).'/payment/success/'.$this->alias.'</strong>
                </div>

                <div class="col-12 mt-3">
                  <label class="form-label mb-1">Failure URL</label>
                  <strong>'.getHost(true).'/payment/failure/'.$this->alias.'</strong>
                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cfe494c750a7c11908a7c19249bf200f").'</label>

                  <input type="text" name="title" class="form-control" value="'.$this->data->title.'" />

                </div>

                <div class="col-12 mt-2">
                  <label class="form-label mb-2">Merchant ID</label>
                  <input type="text" name="params[merchant_id]" class="form-control" value="'.$this->data->params->merchant_id.'">
                </div>

                <div class="col-12 mt-2">
                  <label class="form-label mb-2">Secret Key</label>
                  <input type="password" name="params[secret_key]" class="form-control" value="'.$this->data->params->secret_key.'">
                </div>

                <div class="col-12 mt-2">
                  <label class="form-label mb-2">'.translate("tr_cf55d9a902b71b917a6f0f8aedd4ed11").'</label>
                  <select class="form-select" name="params[currency]">
                    <option value="KZT" '.($this->data->params->currency == "KZT" ? 'selected' : '').'>KZT</option>
                    <option value="USD" '.($this->data->params->currency == "USD" ? 'selected' : '').'>USD</option>
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