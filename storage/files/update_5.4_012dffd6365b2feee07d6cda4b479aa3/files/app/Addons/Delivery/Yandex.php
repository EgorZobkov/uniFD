<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Delivery;

class Yandex{

    public $alias = "yandex";
    public $data;

    public function __construct(){
        global $app;
        $this->data = $this->getData();
    }

    public function getData(){
        global $app;
        $data = $app->model->system_delivery_services->find("alias=?", [$this->alias]);
        if($data){
            $data->params = (object)_json_decode(decrypt($data->params));
            return $data;
        }
    }

    public function sendRequest($url="", $options=[], $access_token=NULL, $post=true) {

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $access_token,
            'Content-Type: application/json',
            'Accept-Language: ru'
        ));
        if($post) curl_setopt ($curl, CURLOPT_POST, 1);
        if($post) curl_setopt ($curl, CURLOPT_POSTFIELDS, $options);
        curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
        if($post) curl_setopt($curl, CURLOPT_HEADER, 0);
        if($post) curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, true);
        if($post) curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, true);
        if($post) curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $body = curl_exec ($curl);
        $result = [];
        $result["status_code"] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result["body"] = $body;
        curl_close ($curl);
        return $result;
    }

    public function replaceCurrencyCode($str=null) {

        return str_replace("RUB", "₽", $str);

    }

    public function clearPoints(){
        global $app;

        $app->model->delivery_points->delete("delivery_id=?", [$this->data->id]);

    }

    public function getLabels($id=0){
        global $app;

        if($this->data->params->test_status){
            $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/request/generate-labels", _json_encode(["request_ids"=>[$id]]), $this->data->params->auth_token);
        }else{
            $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/request/generate-labels", _json_encode(["request_ids"=>[$id]]), $this->data->params->auth_token);
        } 

        $body = $result['body'];

        if($result["status_code"] == 200){

            $filename = md5(time().'-'.uniqid()).'.pdf';
            _file_put_contents($app->config->storage->temp.'/'.$filename, $body);
            $upload = $app->storage->uploadAttachFiles([$filename], $app->config->storage->users->attached);

            return $upload[0];

        }else{
            logger("Delivery ".$this->alias." getLabels error: {$body["message"]}");
            return null;
        }

    }

    public function getHistory($data=[]){
        global $app;

        $history_data = [];

        if(!$data["delivery_answer_data"]["id"]){
            logger("Delivery ".$this->alias." getHistory error: Not found request_id");
            return ["status" => false];
        }

        if($this->data->params->test_status){
            $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/request/info?request_id=".$data["delivery_answer_data"]["id"]."&request_code=".$data["order_id"], null, $this->data->params->auth_token, false);
        }else{
            $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/request/info?request_id=".$data["delivery_answer_data"]["id"]."&request_code=".$data["order_id"], null, $this->data->params->auth_token, false);
        }

        $body = _json_decode($result['body']);

        if($result["status_code"] == 200){

            $history_data = $body;

            if(!$data["delivery_history_data"]["label_url"]){
                $history_data["label_url"] = $this->getLabels($data["delivery_answer_data"]["id"]);
            }else{
                $history_data["label_url"] = $data["delivery_history_data"]["label_url"];
            }

            return ["status" => true, "data"=>$history_data, "sending_status"=>$data["delivery_history_data"]["state"]["status"] == "SORTING_CENTER_AT_START" ? true : false];

        }else{

            logger("Delivery ".$this->alias." getHistory error: {$body["message"]}");
            return ["status" => false, "answer"=>$body["message"]];

        }                

    }

    public function outHistory($data=[], $user_id=0, $out_array = false){
        global $app;

        if($out_array == false){

            if($data["delivery_history_data"]){

                if($user_id == $data["from_user_id"]){
                    return '
                    <div class="addon-delivery-history-container-modal" >
                        <div class="mb-3" >
                            <h6><strong>'.translate("tr_7203f7a4ff564cb876e8db54c903dbfc").'</strong></h6>
                            '.$data["delivery_history_data"]["state"]["description"].'
                        </div>
                        <div>
                            <h6><strong>'.translate("tr_926aced45318d39bf97399d860cb4404").'</strong></h6>
                            <a href="'.$data["delivery_history_data"]["sharing_url"].'" target="_blank" >'.$data["delivery_history_data"]["sharing_url"].'</a>
                        </div>
                    </div>';
                }else{
                    return '
                    <div class="addon-delivery-history-container-modal" >
                        <div class="mb-3" >
                            <h6><strong>'.translate("tr_7203f7a4ff564cb876e8db54c903dbfc").'</strong></h6>
                            '.$data["delivery_history_data"]["state"]["description"].'
                        </div>
                        <div class="mb-3" >
                            <h6><strong>'.translate("tr_9fd95bcec5ab38365b39531cd81401c9").'</strong></h6>
                            <a href="'.getHost()."/".$data["delivery_history_data"]["label_url"].'" target="_blank" >'.translate("tr_e946df6c55054b21acc3a34853fef684").'</a>
                        </div>
                        <div>
                            <h6><strong>'.translate("tr_926aced45318d39bf97399d860cb4404").'</strong></h6>
                            <a href="'.$data["delivery_history_data"]["sharing_url"].'" target="_blank" >'.$data["delivery_history_data"]["sharing_url"].'</a>
                        </div>
                    </div>';
                }

            } 

            return '<div class="addon-delivery-history-container-modal text-center" >
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden"></span>
            </div>        
            <p>'.translate("tr_bed236666adcca1d41c7fd73e6b0b3b2").'</p>
            </div>';   

        }else{

            if($data["delivery_history_data"]){

                if($user_id == $data["from_user_id"]){
                    return [
                        "status_description" => $data["delivery_history_data"]["state"]["description"],
                        "tracking_url" => $data["delivery_history_data"]["sharing_url"],
                        "tracking_code" => null,
                        "label_url" => null,
                    ];
                }else{
                    return [
                        "status_description" => $data["delivery_history_data"]["state"]["description"],
                        "tracking_url" => $data["delivery_history_data"]["sharing_url"],
                        "tracking_code" => null,
                        "label_url" => getHost()."/".$data["delivery_history_data"]["label_url"],
                    ];
                }

            } 

            return [];

        }              

    }

    public function getPoints(){
        global $app;

        $this->clearPoints();

        if(!$app->model->delivery_points->count("delivery_id=?", [$this->data->id]) && $this->data->params->auth_token){

            if($this->data->params->test_status){
                $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/pickup-points/list", [], $this->data->params->auth_token);
            }else{
                $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/pickup-points/list", [], $this->data->params->auth_token);
            }

            $body = _json_decode($result['body']);

            if($result["status_code"] == 200){

                foreach ($body['points'] as $value) {

                    $payment_method = 0;

                    if(is_array($value['payment_methods'])){
                        if(in_array("card_on_receipt", $value['payment_methods'])){
                            $payment_method = 1;
                        }
                    }

                    $app->model->delivery_points->insert([
                        "code" => $value['id'],
                        "address" => $value['address']['full_address'],
                        "latitude" => $value['position']['latitude'],
                        "longitude" => $value['position']['longitude'],
                        "workshedule" => null,
                        "available_payment" => $payment_method,
                        "text" => $value['instruction'] ?? null,
                        "city_code" => $value['address']['geoId'] ?? null,
                        "send" => $value['available_for_dropoff'] ? 1 : 0,
                        "delivery_id" => $this->data->id,
                    ]);

                }

            }else{

                logger("Delivery ".$this->alias." getPoints error: ".print_r($body, true));

            }

        }

    }
    
    public function createOrder($params=[]){
        global $app;

        $data = [];

        $data["destination"] = [
            "type" => "platform_station",
            "platform_station" => [
                "platform_id" => $params->data->delivery_point->code
            ],
        ];

        $data["source"] = [
            "type" => "platform_station",
            "platform_station" => [
                "platform_id" => $params->data->user_shipping_point->code
            ],
        ];

        $data["info"] = [
            "operator_request_id" => $params->data->order_id
        ];

        $data["items"] = [
            [
                "article" => $params->data->item->id,
                "billing_details" => [
                    "assessed_unit_price" => $params->data->item->amount * 100,
                    "unit_price" => $params->data->item->amount * 100
                ],
                "count" => (int)$params->data->item->count,
                "name" => $params->ad->title,
                "place_barcode" => "BOX_" . $params->data->item->id
            ]
        ];

        $data["last_mile_policy"] = "self_pickup";

        $data["places"] = [
            [
                "barcode" => "BOX_" . $params->data->item->id,
                "physical_dims" => [
                    "dx" => (int)$params->ad->category->delivery_size_depth ?: 50,
                    "dy" => (int)$params->ad->category->delivery_size_height ?: 50,
                    "dz" => (int)$params->ad->category->delivery_size_width ?: 30,
                    "weight_gross" => (int)$params->ad->category->delivery_size_weight ?: 1000,
                ]
            ]
        ];

        $data["billing_info"] = [
            "payment_method" => "already_paid",
        ];

        $data["recipient_info"] = [
            "first_name" => $params->data->delivery_data["recipient"]["name"],
            "last_name" => $params->data->delivery_data["recipient"]["surname"],
            "phone" => $params->data->delivery_data["recipient"]["phone"],
            "email" => $params->data->delivery_data["recipient"]["email"] ?? ''
        ];

        if($this->data->params->test_status){
            $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/request/create?send_unix=false", _json_encode($data), $this->data->params->auth_token);
        }else{
            $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/request/create?send_unix=false", _json_encode($data), $this->data->params->auth_token);
        }

        $body = _json_decode($result['body']);

        if($body["request_id"]){

            return [
                "status" => true, 
                "id" => $body["request_id"],
                "comment_to_sender" => null,
                "comment_to_recipient" => null,
                "shipping_point_code" => $params->data->user_shipping_point->code
            ];      

        }else{

            logger("Delivery ".$this->alias." createOrder error: {$body["message"]}");
            return ["status" => false, "answer" => $body["message"]];

        }                

    }

    public function cancelOrder($params=[]){
        global $app;

        if(!$params["id"]){
            logger("Delivery ".$this->alias." cancelOrder error: Not found request_id");
            return ["status" => false];
        }

        if($this->data->params->test_status){
            $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/request/cancel", _json_encode(["request_id"=>$params["id"]]), $this->data->params->auth_token);
        }else{
            $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/request/cancel", _json_encode(["request_id"=>$params["id"]]), $this->data->params->auth_token);
        }

        $body = _json_decode($result['body']);

        if($result["status_code"] == 200){

            return ["status" => true, "answer"=>$body["description"]];

        }else{

            logger("Delivery ".$this->alias." cancelOrder error: {$body["message"]}");
            return ["status" => false, "answer"=>$body["message"]];

        }                

    }

    public function calculation($params=[]){
        global $app;

        $data = [];

        $data["destination"] = [
            "platform_station_id" => $params->data->delivery_point->code,
        ];

        $data["source"] = [
            "platform_station_id" => $params->data->user_shipping_point->code,
        ];

        $data["tariff"] = "self_pickup";
        $data["total_weight"] = (int)$params->ad->category->delivery_size_weight ?: 1000;

        if($this->data->params->test_status){
            $result = $this->sendRequest("https://b2b.taxi.tst.yandex.net/api/b2b/platform/pricing-calculator", _json_encode($data), $this->data->params->auth_token);
        }else{
            $result = $this->sendRequest("https://b2b-authproxy.taxi.yandex.net/api/b2b/platform/pricing-calculator", _json_encode($data), $this->data->params->auth_token);
        }

        $body = _json_decode($result['body']);

        if($result["status_code"] == 200){

            return [
                "status" => true, 
                "amount" => $this->replaceCurrencyCode($body["pricing_total"]), 
                "amount_formatted" => formattedPrice($body["pricing_total"]), 
                "days" => $body["delivery_days"] ? $body["delivery_days"] . ' ' . endingWord($body["delivery_days"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")) : null,
            ];

        }else{

            logger("Delivery ".$this->alias." calculationDelivery error: {$body["message"]}");
            return ["status" => false];

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

    public function fieldsForm($params=[]){
        global $app;

        return '
        <form class="integrationDeliveryForm" >

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
                      <input type="checkbox" name="params[test_status]" value="1" class="switch-input" '.($this->data->params->test_status ? 'checked=""' : '').' >
                      <span class="switch-toggle-slider">
                        <span class="switch-on"></span>
                        <span class="switch-off"></span>
                      </span>
                      <span class="switch-label">Test mode</span>
                    </label>

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Auth Token</label>

                  <input type="text" name="params[auth_token]" class="form-control" value="'.$this->data->params->auth_token.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_5bf2cff001d36b038eabc3ae7660fcd9").'</label>

                  <input type="number" name="available_price_min" class="form-control" value="'.$this->data->available_price_min.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_bf939ddd3c5df260fce70c996785c7d6").'</label>

                  <input type="number" name="available_price_max" class="form-control" value="'.$this->data->available_price_max.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_ab223d16e2cfcd7e59cd23af7ae6bc88").'</label>

                  <input type="number" name="min_weight" class="form-control" value="'.$this->data->min_weight.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_e82192b8980d7924578688c149661978").'</label>

                  <input type="number" name="max_weight" class="form-control" value="'.$this->data->max_weight.'" />

                </div>

                <input type="hidden" name="id" value="'.$this->data->id.'" />

                <div class="mt-4 d-grid col-lg-6 mx-auto">
                  <button class="btn btn-primary buttonIntegrationDeliverySave">'.translate("tr_74ea58b6a801f0dce4e5d34dbca034dc").'</button>
                </div>

            </div>

        </form>
        ';

    }


}