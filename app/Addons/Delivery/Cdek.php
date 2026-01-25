<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Addons\Delivery;

class Cdek{

    public $alias = "cdek";
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

    public function logo(){
        global $app;

        if(!$app->storage->name($this->data->image)->exist()){
            return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfQAAACMCAYAAACK0FuSAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAydpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDkuMS1jMDAyIDc5LmE2YTYzOTY4YSwgMjAyNC8wMy8wNi0xMTo1MjowNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjExIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5MjMzQUQyQ0E1MTgxMUYwQjk0MEE4ODBFRkY0ODIzNyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo5MjMzQUQyREE1MTgxMUYwQjk0MEE4ODBFRkY0ODIzNyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjkyMzNBRDJBQTUxODExRjBCOTQwQTg4MEVGRjQ4MjM3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjkyMzNBRDJCQTUxODExRjBCOTQwQTg4MEVGRjQ4MjM3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+cdqxvgAAN0dJREFUeNrs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';
        }else{
            return $app->storage->name($this->data->image)->get();
        }
    }

    public function searchPoints($query="", $delivery_id=0){
        global $app;

        if(_mb_strlen($query) < 2){
            return [];
        }

        $result = [];

        if($delivery_id){
            $data = $app->model->delivery_points->sort("address asc")->search($query)->getAll("delivery_id=?",[$delivery_id]);
        }else{
            $data = $app->model->delivery_points->sort("address asc")->search($query)->getAll();
        }

        if($data){

            foreach ($data as $value) {

                $result[] = ["id"=>$value["id"], "delivery_id"=>$value["delivery_id"]?:0, "address"=>$value["address"], "latitude"=>$value["latitude"]?:0, "longitude"=>$value["longitude"]?:0, "code_point"=>$value["code"]];

            }

        }

        return $result;

    }

    public function getPoints(){
        global $app;

        if(!$app->model->delivery_points->count("delivery_id=?", [$this->data->id])){

            // Учетные данные СДЭК
            $account = $this->data->params->account;
            $secure = $this->data->params->secure;

            // Формирование заголовка для аутентификации
            $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => "Authorization: Basic ".base64_encode("$account:$secure")."\r\n"
                ]
            ];
            $context = stream_context_create($opts);

            // Запрос для получения пунктов выдачи СДЭК
            $url = 'https://api.cdek.ru/v2/deliverypoints';

            $response = @file_get_contents($url, false, $context);
            if ($response === false) {
                $error = error_get_last();
                logger("Delivery ".$this->alias." getPoints error: ".$error['message']);
                return;
            }

            $getPoints = _json_decode($response);

            if($getPoints && is_array($getPoints)){
                foreach ($getPoints as $point) {
                    $app->model->delivery_points->insert([
                        "code" => $point['code'],
                        "address" => $point['address'] ?? $point['name'],
                        "latitude" => $point['location']['latitude'],
                        "longitude" => $point['location']['longitude'],
                        "workshedule" => $point['work_time'],
                        "text" => $point['name'],
                        "city_code" => $point['location']['city_code'],
                        "send" => 0,
                        "delivery_id" => $this->data->id
                    ]);
                }
            } else {
                logger("Delivery ".$this->alias." getPoints error: empty or invalid response");
            }
        }
    }
	
	/*
	* Запрос к сдек для получения токена.
	*/

    private function getCdekToken($account, $secure) {
        $url = 'https://api.cdek.ru/v2/oauth/token';
        $data = [
            'grant_type' => 'client_credentials',
            'client_id' => $account,
            'client_secret' => $secure
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            return false;
        }

        $response = _json_decode($response);
        return $response['access_token'] ?? false;
    }

    public function createOrder($params=[]){
        global $app;

        // Запрос на получени токена
        $account = $this->data->params->account;
        $secure = $this->data->params->secure;
        $token = $this->getCdekToken($account, $secure);
        
        if (!$token) {
            logger("Delivery ".$this->alias." createOrder error: Failed to get token");
            return ["status"=>false];
        }

        // Формируем данные для заказа
        $order_data = [
            'type' => 1,
            'number' => $params->data->order_id,
            'tariff_code' => 136, // Тариф "Посылка склад-склад"
            'sender' => [
                'company' => $this->data->params->sender_company,
                'name' => $this->data->params->sender_name,
                'phones' => [['number' => $this->data->params->sender_phone]],
                'address' => $this->data->params->sender_address
            ],
            'recipient' => [
                'name' => $params->data->delivery_data["recipient"]["surname"].' '.$params->data->delivery_data["recipient"]["name"].' '.$params->data->delivery_data["recipient"]["patronymic"],
                'phones' => $params->data->delivery_data["recipient"]["phone"],
                'email' => $params->data->delivery_data["recipient"]["email"],
                'delivery_point' => $params->data->user_shipping_point->code
            ],
            'packages' => [
                [
                    'number' => $params->data->order_id,
                    'weight' => $params->ad->category->delivery_size_weight * 1000, // кг → граммы
                    'length' => 10,
                    'width' => 10,
                    'height' => 10
                ]
            ]
        ];

        // Отправка запроса на создание заказа
        $url = 'https://api.cdek.ru/v2/orders';
        $headers = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode != 200) {
            logger("Delivery ".$this->alias." createOrder error: ".$response);
            return ["status"=>false];
        }

        $result = _json_decode($response);
        $track_number = $result['entity']['cdek_number'] ?? '';
        $uuid = $result['entity']['uuid'] ?? '';

        if(!$track_number){
            logger("Delivery ".$this->alias." createOrder error: Track number not found");
            return ["status"=>false];
        }

        return [
            "status"=>true, 
            "id"=>$uuid, 
            "track_number"=>$track_number, 
            "label"=>"", 
            "shipping_point_id"=>$params->data->user_shipping_point->id
        ];             

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

                  <label class="form-label mb-2" >'.translate("tr_55c9488fbbf51f974a38acd8ccb87ee1").'</label>

                  '.$app->ui->managerFiles(["filename"=>$this->data->image, "type"=>"images", "path"=>"images"]).'

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >'.translate("tr_602680ed8916dcc039882172ef089256").'</label>

                  <input type="text" name="name" class="form-control" value="'.$this->data->name.'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Account (логин СДЭК)</label>

                  <input type="text" name="params[account]" class="form-control" value="'.($this->data->params->account ?? '').'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Secure (пароль СДЭК)</label>

                  <input type="text" name="params[secure]" class="form-control" value="'.($this->data->params->secure ?? '').'" />

                </div>

                <div class="col-12 mt-3">

                  <label class="form-label mb-2" >Отправитель: компания</label>

                  <input type="text" name="params[sender_company]" class="form-control" value="'.($this->data->params->sender_company ?? '').'" />

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

        </from>
        ';
    }
}