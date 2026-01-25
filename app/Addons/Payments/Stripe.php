<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Payments;

class Stripe{

    public $alias = "stripe";
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
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHwAAAA0CAYAAABIFVy/AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpGNjFBMjk4QTEwNzQxMUYwQjdBQUJGOUM3MjNEQzFCOCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDpGNjFBMjk4QjEwNzQxMUYwQjdBQUJGOUM3MjNEQzFCOCI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkY2MUEyOTg4MTA3NDExRjBCN0FBQkY5QzcyM0RDMUI4IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkY2MUEyOTg5MTA3NDExRjBCN0FBQkY5QzcyM0RDMUI4Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+UfDm3QAAEmZJREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }

    }

    public function createPayment($params=[]){
        global $app;

        $currency = $this->currency();

        try {
        
            $stripe = new \Stripe\StripeClient($this->data->params->secret_key);

            $product = $stripe->products->create(['name' => $params["title"]]);

            $price = $stripe->prices->create(
              [
                'product' => $product['id'],
                'unit_amount' => $currency[$this->data->params->currency]['zero-decimal'] ? $params["amount"] : $params["amount"]*100,
                'currency' => $this->data->params->currency,
              ]
            );

            $result = $stripe->paymentLinks->create(
              [
                'line_items' => [['price' => $price['id'], 'quantity' => 1]],
                'after_completion' => [
                  'type' => 'redirect',
                  'redirect' => ['url' => getHost(true).'/payment/status/order/'.$params["order_id"]],
                ],
                'metadata' => ['order_id' => $params["order_id"]],
              ]
            );

            return ["link"=>urldecode($result['url'])];

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayment error: {$e->getMessage()}");
        }

    }

    public function createPayout($data=[]){
        global $app;

        try {
            if(!$data->user_id || !$data->amount){
                throw new \Exception("Missing payout data");
            }

            $currency = $this->currency();
            $is_zero_decimal = $currency[$this->data->params->currency]['zero-decimal'] ?? 0;
            $amount = $is_zero_decimal ? $data->amount : $data->amount * 100;

            $stripe = new \Stripe\StripeClient($this->data->params->secret_key);

            // Проверяем тип выплаты: на карту или аккаунт Stripe
            if($data->payout_type === 'card') {
                // Создаем получателя для карты     
                $recipient = $stripe->recipient::create([
                    'name' => $data['user']->name,
                    'type' => 'individual',
                    'bank_account' => $data["payment_data"]["score"],
                    'email' => $data['user']->email,
                ]);

                if(!$recipient) {
                    throw new \Exception("Failed to create card recipient");
                }

                // Создаем трансфер на карту                
                $transfer = $stripe->payout::create([
                    'amount' => round($data["amount"], 2) * 100,
                    'currency' => $app->system->getDefaultCurrency()->code,
                    'description' => $data["title"],
                    'method' => 'instant',
                    'recipient' => $recipient->id,
                    'statement_descriptor' => substr($data["title"], 0, 22),
                ]);

                $payout_data = [
                    'transfer_id' => $transfer->id,
                    'recipient_id' => $recipient->id,
                    'type' => 'card',
                    'amount' => $data->amount,
                    'currency' => $this->data->params->currency,
                    'status' => $transfer->status
                ];

            } else {
                // Существующая логика для выплат на Stripe аккаунт
                $user = $app->model->user->find("id=?", [$data->user_id]);
                if(!$user || !$user->stripe_account_id){
                    throw new \Exception("User Stripe account not connected");
                }

                $payout = $stripe->payouts->create([
                    'amount' => $amount,
                    'currency' => $this->data->params->currency,
                    'destination' => $user->stripe_account_id,
                ], ['stripe_account' => $user->stripe_account_id]);

                $payout_data = [
                    'payout_id' => $payout->id,
                    'amount' => $data->amount,
                    'currency' => $this->data->params->currency,
                    'status' => $payout->status
                ];
            }

            // Обновление статуса операции
            $app->model->transactions_operations->update([
                "status_processing" => "success",
                "payout_data" => json_encode($payout_data)
            ], ["id=?", [$data->id]]);

            return $payout_data;

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createPayout error: {$e->getMessage()}");
            $app->model->transactions_operations->update([
                "status_processing" => "error",
                "error_message" => $e->getMessage()
            ], ["id=?", [$data->id]]);
            return false;
        }
    }

    public function createRefund($data=[]){
        global $app;

        try {
            $operation = $app->model->transactions_operations->find("id=?", [$data->operation_id]);
            if(!$operation || !$operation->data){
                throw new \Exception("Original transaction not found");
            }

            $transaction_data = _json_decode($operation->data);
            $payment_intent_id = $transaction_data['stripe_payment_intent_id'] ?? null;
            
            if(!$payment_intent_id){
                throw new \Exception("Payment intent ID missing");
            }

            $currency = $this->currency();
            $is_zero_decimal = $currency[$this->data->params->currency]['zero-decimal'] ?? 0;
            $amount = $is_zero_decimal ? $data->amount : $data->amount * 100;

            $stripe = new \Stripe\StripeClient($this->data->params->secret_key);

            $refund = $stripe->refunds->create([
                'payment_intent' => $payment_intent_id,
                'amount' => $amount,
            ]);

            $app->model->transactions_operations->update([
                "status_processing" => "success",
                "refund_data" => json_encode([
                    'refund_id' => $refund->id,
                    'amount' => $data->amount,
                    'currency' => $this->data->params->currency,
                    'status' => $refund->status
                ])
            ], ["id=?", [$data->id]]);

            return $refund;

        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createRefund error: {$e->getMessage()}");
            $app->model->transactions_operations->update([
                "status_processing" => "error",
                "error_message" => $e->getMessage()
            ], ["id=?", [$data->id]]);
        }
    }

    public function currency(){
        global $app;

        return [
            'USD'=>['zero-decimal'=>0, 'country'=>''],
            'AED'=>['zero-decimal'=>0, 'country'=>''],
            'AFN'=>['zero-decimal'=>0, 'country'=>''],
            'ALL'=>['zero-decimal'=>0, 'country'=>''],
            'AMD'=>['zero-decimal'=>0, 'country'=>''],
            'ANG'=>['zero-decimal'=>0, 'country'=>''],
            'AOA'=>['zero-decimal'=>0, 'country'=>''],
            'ARS'=>['zero-decimal'=>0, 'country'=>''],
            'AUD'=>['zero-decimal'=>0, 'country'=>''],
            'AWG'=>['zero-decimal'=>0, 'country'=>''],
            'AZN'=>['zero-decimal'=>0, 'country'=>''],
            'BAM'=>['zero-decimal'=>0, 'country'=>''],
            'BBD'=>['zero-decimal'=>0, 'country'=>''],
            'BDT'=>['zero-decimal'=>0, 'country'=>''],
            'BGN'=>['zero-decimal'=>0, 'country'=>''],
            'BIF'=>['zero-decimal'=>1, 'country'=>''],
            'BMD'=>['zero-decimal'=>0, 'country'=>''],
            'BND'=>['zero-decimal'=>0, 'country'=>''],
            'BOB'=>['zero-decimal'=>0, 'country'=>''],
            'BRL'=>['zero-decimal'=>0, 'country'=>''],
            'BSD'=>['zero-decimal'=>0, 'country'=>''],
            'BWP'=>['zero-decimal'=>0, 'country'=>''],
            'BYN'=>['zero-decimal'=>0, 'country'=>''],
            'BZD'=>['zero-decimal'=>0, 'country'=>''],
            'CAD'=>['zero-decimal'=>0, 'country'=>''],
            'CDF'=>['zero-decimal'=>0, 'country'=>''],
            'CHF'=>['zero-decimal'=>0, 'country'=>''],
            'CLP'=>['zero-decimal'=>1, 'country'=>''],
            'CNY'=>['zero-decimal'=>0, 'country'=>''],
            'COP'=>['zero-decimal'=>0, 'country'=>''],
            'CRC'=>['zero-decimal'=>0, 'country'=>''],
            'CVE'=>['zero-decimal'=>0, 'country'=>''],
            'CZK'=>['zero-decimal'=>0, 'country'=>''],
            'DJF'=>['zero-decimal'=>1, 'country'=>''],
            'DKK'=>['zero-decimal'=>0, 'country'=>''],
            'DOP'=>['zero-decimal'=>0, 'country'=>''],
            'DZD'=>['zero-decimal'=>0, 'country'=>''],
            'EGP'=>['zero-decimal'=>0, 'country'=>''],
            'ETB'=>['zero-decimal'=>0, 'country'=>''],
            'EUR'=>['zero-decimal'=>0, 'country'=>''],
            'FJD'=>['zero-decimal'=>0, 'country'=>''],
            'FKP'=>['zero-decimal'=>0, 'country'=>''],
            'GBP'=>['zero-decimal'=>0, 'country'=>''],
            'GEL'=>['zero-decimal'=>0, 'country'=>''],
            'GIP'=>['zero-decimal'=>0, 'country'=>''],
            'GMD'=>['zero-decimal'=>0, 'country'=>''],
            'GNF'=>['zero-decimal'=>1, 'country'=>''],
            'GTQ'=>['zero-decimal'=>0, 'country'=>''],
            'GYD'=>['zero-decimal'=>0, 'country'=>''],
            'HKD'=>['zero-decimal'=>0, 'country'=>''],
            'HNL'=>['zero-decimal'=>0, 'country'=>''],
            'HRK'=>['zero-decimal'=>0, 'country'=>''],
            'HTG'=>['zero-decimal'=>0, 'country'=>''],
            'HUF'=>['zero-decimal'=>0, 'country'=>''],
            'IDR'=>['zero-decimal'=>0, 'country'=>''],
            'ILS'=>['zero-decimal'=>0, 'country'=>''],
            'INR'=>['zero-decimal'=>0, 'country'=>''],
            'ISK'=>['zero-decimal'=>0, 'country'=>''],
            'JMD'=>['zero-decimal'=>0, 'country'=>''],
            'JPY'=>['zero-decimal'=>1, 'country'=>''],
            'KES'=>['zero-decimal'=>0, 'country'=>''],
            'KGS'=>['zero-decimal'=>0, 'country'=>''],
            'KHR'=>['zero-decimal'=>0, 'country'=>''],
            'KMF'=>['zero-decimal'=>1, 'country'=>''],
            'KRW'=>['zero-decimal'=>1, 'country'=>''],
            'KYD'=>['zero-decimal'=>0, 'country'=>''],
            'KZT'=>['zero-decimal'=>0, 'country'=>''],
            'LAK'=>['zero-decimal'=>0, 'country'=>''],
            'LBP'=>['zero-decimal'=>0, 'country'=>''],
            'LKR'=>['zero-decimal'=>0, 'country'=>''],
            'LRD'=>['zero-decimal'=>0, 'country'=>''],
            'LSL'=>['zero-decimal'=>0, 'country'=>''],
            'MAD'=>['zero-decimal'=>0, 'country'=>''],
            'MDL'=>['zero-decimal'=>0, 'country'=>''],
            'MGA'=>['zero-decimal'=>1, 'country'=>''],
            'MKD'=>['zero-decimal'=>0, 'country'=>''],
            'MMK'=>['zero-decimal'=>0, 'country'=>''],
            'MNT'=>['zero-decimal'=>0, 'country'=>''],
            'MOP'=>['zero-decimal'=>0, 'country'=>''],
            'MRO'=>['zero-decimal'=>0, 'country'=>''],
            'MUR'=>['zero-decimal'=>0, 'country'=>''],
            'MVR'=>['zero-decimal'=>0, 'country'=>''],
            'MWK'=>['zero-decimal'=>0, 'country'=>''],
            'MXN'=>['zero-decimal'=>0, 'country'=>''],
            'MYR'=>['zero-decimal'=>0, 'country'=>''],
            'MZN'=>['zero-decimal'=>0, 'country'=>''],
            'NAD'=>['zero-decimal'=>0, 'country'=>''],
            'NGN'=>['zero-decimal'=>0, 'country'=>''],
            'NIO'=>['zero-decimal'=>0, 'country'=>''],
            'NOK'=>['zero-decimal'=>0, 'country'=>''],
            'NPR'=>['zero-decimal'=>0, 'country'=>''],
            'NZD'=>['zero-decimal'=>0, 'country'=>''],
            'PAB'=>['zero-decimal'=>0, 'country'=>''],
            'PEN'=>['zero-decimal'=>0, 'country'=>''],
            'PGK'=>['zero-decimal'=>0, 'country'=>''],
            'PHP'=>['zero-decimal'=>0, 'country'=>''],
            'PKR'=>['zero-decimal'=>0, 'country'=>''],
            'PLN'=>['zero-decimal'=>0, 'country'=>''],
            'PYG'=>['zero-decimal'=>1, 'country'=>''],
            'QAR'=>['zero-decimal'=>0, 'country'=>''],
            'RON'=>['zero-decimal'=>0, 'country'=>''],
            'RSD'=>['zero-decimal'=>0, 'country'=>''],
            'RUB'=>['zero-decimal'=>0, 'country'=>''],
            'RWF'=>['zero-decimal'=>1, 'country'=>''],
            'SAR'=>['zero-decimal'=>0, 'country'=>''],
            'SBD'=>['zero-decimal'=>0, 'country'=>''],
            'SCR'=>['zero-decimal'=>0, 'country'=>''],
            'SEK'=>['zero-decimal'=>0, 'country'=>''],
            'SGD'=>['zero-decimal'=>0, 'country'=>''],
            'SHP'=>['zero-decimal'=>0, 'country'=>''],
            'SLL'=>['zero-decimal'=>0, 'country'=>''],
            'SOS'=>['zero-decimal'=>0, 'country'=>''],
            'SRD'=>['zero-decimal'=>0, 'country'=>''],
            'STD'=>['zero-decimal'=>0, 'country'=>''],
            'SZL'=>['zero-decimal'=>0, 'country'=>''],
            'THB'=>['zero-decimal'=>0, 'country'=>''],
            'TJS'=>['zero-decimal'=>0, 'country'=>''],
            'TOP'=>['zero-decimal'=>0, 'country'=>''],
            'TRY'=>['zero-decimal'=>0, 'country'=>''],
            'TTD'=>['zero-decimal'=>0, 'country'=>''],
            'TWD'=>['zero-decimal'=>0, 'country'=>''],
            'TZS'=>['zero-decimal'=>0, 'country'=>''],
            'UAH'=>['zero-decimal'=>0, 'country'=>''],
            'UGX'=>['zero-decimal'=>1, 'country'=>''],
            'UYU'=>['zero-decimal'=>0, 'country'=>''],
            'UZS'=>['zero-decimal'=>0, 'country'=>''],
            'VND'=>['zero-decimal'=>1, 'country'=>''],
            'VUV'=>['zero-decimal'=>1, 'country'=>''],
            'WST'=>['zero-decimal'=>0, 'country'=>''],
            'XAF'=>['zero-decimal'=>1, 'country'=>''],
            'XCD'=>['zero-decimal'=>0, 'country'=>''],
            'XOF'=>['zero-decimal'=>1, 'country'=>''],
            'XPF'=>['zero-decimal'=>1, 'country'=>''],
            'YER'=>['zero-decimal'=>0, 'country'=>''],
            'ZAR'=>['zero-decimal'=>0, 'country'=>''],
            'ZMW'=>['zero-decimal'=>0, 'country'=>''],
            ];

    }

    public function callback($action=null){
        global $app;

        try {

            $payload = _file_get_contents('php://input');
            $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
            $event = null;

            try {

                $event = \Stripe\Webhook::constructEvent(
                    $payload, $sig_header, $this->data->params->secret_webhook
                );

            } catch(\UnexpectedValueException $e) {
                logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
                http_response_code(400);
                exit();

            } catch(\Stripe\Exception\SignatureVerificationException $e) {
                logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
                http_response_code(400);
                exit();

            }

            switch ($event->type) {
                
                case 'checkout.session.completed':
                    $session = $event->data->object;
                    $order_id = $session->metadata->order_id;
                    
                    $order = $app->component->transaction->getOperation($order_id);
                    
                    if($order){
                        // Сохраняем payment intent ID
                        $transaction_data = $order->data ? _json_decode($order->data) : [];
                        $transaction_data['stripe_payment_intent_id'] = $session->payment_intent;
                        
                        $app->model->transactions_operations->update([
                            "data" => _json_encode($transaction_data)
                        ], ["order_id=?", [$order_id]]);
                        
                        $app->component->transaction->callback($order->data, $payload);
                        header("HTTP/1.1 200 OK");
                    }
                    
                break;
                
                case 'transfer.paid':
                case 'transfer.failed':
                    $transfer = $event->data->object;
                    $operation = $app->model->transactions_operations->find("payout_data LIKE ?", ['%"transfer_id":"' . $transfer->id . '"%']);
                    
                    if ($operation) {
                        $payout_data = $operation->payout_data ? json_decode($operation->payout_data, true) : [];
                        $payout_data['status'] = $transfer->status;
                        
                        $app->model->transactions_operations->update([
                            "payout_data" => json_encode($payout_data),
                            "status_processing" => $transfer->status
                        ], ["id=?", [$operation->id]]);
                    }
                    header("HTTP/1.1 200 OK");
                break;

                default:

                    logger("Payment ".$this->alias." callback error: Received unknown event type ".$event->type);

            }

        } catch (Exception $e) {
            logger("Payment ".$this->alias." callback error: {$e->getMessage()}");
            header("HTTP/1.1 404 ERROR");
        }

    }

    public function fieldsForm($params=[]){
        global $app;

        $currency_options = '';

        if($this->currency()){
            foreach ($this->currency() as $key => $value) {
                $currency_options .= '<option value="'.$key.'" '.($this->data->params->currency == $key ? 'selected=""' : '').' >'.$key.'</option>';
            }
        }

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

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cfe494c750a7c11908a7c19249bf200f").'</label>

                  <input type="text" name="title" class="form-control" value="'.$this->data->title.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Secret key</label>

                  <input type="text" name="params[secret_key]" class="form-control" value="'.$this->data->params->secret_key.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Webhook secret</label>

                  <input type="text" name="params[secret_webhook]" class="form-control" value="'.$this->data->params->secret_webhook.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_cf55d9a902b71b917a6f0f8aedd4ed11").'</label>

                  <select class="form-select selectpicker" name="params[currency]" title="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >
                    '.$currency_options.'
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
    
    public function createCardRecipient($data) {
        global $app;
        
        try {
            $stripe = new \Stripe\StripeClient($this->data->params->secret_key);
            
            $recipient = $stripe->recipients->create([
                'name' => $data['name'],
                'type' => 'individual',
                'bank_account' => [
                    'country' => $data['country'],
                    'currency' => $this->data->params->currency,
                    'account_holder_name' => $data['account_holder_name'],
                    'account_holder_type' => 'individual',
                    'routing_number' => $data['routing_number'],
                    'account_number' => $data['account_number'],
                ],
            ]);

            return $recipient;
            
        } catch (\Exception $e) {
            logger("Payment ".$this->alias." createCardRecipient error: {$e->getMessage()}");
            return false;
        }
    }


}