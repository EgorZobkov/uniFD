<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class DeliveryController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function searchPoints(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        return json_answer(["data"=>$this->component->delivery->searchPoints($_GET["id"], $_GET["query"]), "auth"=>true]);

    }

    public function pointsMarkers(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $data = [];
        $result = [];

        $delivery = $this->model->system_delivery_services->find("id=?", [(int)$_GET["id"]]);

        if(!$delivery){
            return json_answer(["data"=>[], "auth"=>true]);
        }

        $data = $this->model->delivery_points->getAll("delivery_id=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [(int)$_GET["id"],$_GET["topLeft"]?:null,$_GET["topRight"]?:null,$_GET["bottomLeft"]?:null,$_GET["bottomRight"]?:null]);

        if($data){

            foreach ($data as $key => $value) {
                $result[] = ["id"=>$value["id"], "point_code"=>$value["code"], "delivery_name"=>$delivery->name, "latitude"=>$value["latitude"]?:null, "longitude"=>$value["longitude"]?:null, "address"=>$value["address"]?:null, "workshedule"=>$value["workshedule"]?:null, "text"=>$value["text"]?:null, "change_point_status"=>true];
            }

        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function getPoint(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $data = [];
        $result = [];

        $data = $this->model->delivery_points->find("id=?", [(int)$_GET['point_id']]);

        if($data){

            $delivery = $this->model->system_delivery_services->find("id=?", [$data->delivery_id]);

            if($delivery){

                if($delivery->required_price_order){

                    $calculationData = $this->component->delivery->calculationData($data->id, (int)$_GET['item_id'], $_GET['user_id']);

                    if($calculationData["status"] == true){
                        $result = ["id"=>$data->id, "point_code"=>$data->code, "delivery_name"=>$delivery->name, "required_price_order"=>$delivery->required_price_order ? true : false, "latitude"=>$data->latitude ?: null, "longitude"=>$data->longitude ?: null, "address"=>$data->address ?: null, "workshedule"=>$data->workshedule ?: null, "text"=>$data->text ?: null, "extra_text"=> $calculationData["status"] == true ? translate("tr_76e3ea03ca3d1c8c086fcec30aaaa94d") . ' ' . $calculationData["amount"] . ', ' . $calculationData["days"] : null, "amount"=>$calculationData["amount_formatted"] ?: null, "days"=>$calculationData["days"] ?: null, "change_point_status"=>true];
                    }else{
                        $result = ["id"=>$data->id, "point_code"=>$data->code, "delivery_name"=>$delivery->name, "required_price_order"=>$delivery->required_price_order ? true : false, "latitude"=>$data->latitude ?: null, "longitude"=>$data->longitude ?: null, "address"=>$data->address ?: null, "workshedule"=>$data->workshedule ?: null, "text"=>$data->text ?: null, "extra_text"=> null, "amount"=>null, "days"=>null, "change_point_status"=>false];
                    }

                }else{

                    $calculationData = $this->component->delivery->calculationData($data->id, (int)$_GET['item_id'], $_GET['user_id']);

                    if($calculationData["status"] == true){
                        $result = ["id"=>$data->id, "point_code"=>$data->code, "delivery_name"=>$delivery->name, "required_price_order"=>$delivery->required_price_order ? true : false, "latitude"=>$data->latitude ?: null, "longitude"=>$data->longitude ?: null, "address"=>$data->address ?: null, "workshedule"=>$data->workshedule ?: null, "text"=>$data->text ?: null, "extra_text"=> $calculationData["status"] == true ? translate("tr_76e3ea03ca3d1c8c086fcec30aaaa94d") . ' ' . $calculationData["amount"] . ', ' . $calculationData["days"] : null, "amount"=>$calculationData["amount_formatted"] ?: null, "days"=>$calculationData["days"] ?: null, "change_point_status"=>true];
                    }else{
                        $result = ["id"=>$data->id, "point_code"=>$data->code, "delivery_name"=>$delivery->name, "required_price_order"=>$delivery->required_price_order ? true : false, "latitude"=>$data->latitude ?: null, "longitude"=>$data->longitude ?: null, "address"=>$data->address ?: null, "workshedule"=>$data->workshedule ?: null, "text"=>$data->text ?: null, "extra_text"=> null, "amount"=>null, "days"=>null, "change_point_status"=>true];
                    }

                }

            }

        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function getHistory(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $order = $this->model->transactions_deals->find("order_id=? and (from_user_id=? or whom_user_id=?)", [$_POST['order_id'],$_POST['user_id'],$_POST['user_id']]);
        if($order){
            if($order->delivery_service_id){
                $service = $this->model->system_delivery_services->find("id=?", [$order->delivery_service_id]);
                if($service){
                    $order->delivery_history_data = $order->delivery_history_data ? _json_decode(decrypt($order->delivery_history_data)) : [];
                    $result = $this->addons->delivery($service->alias)->outHistory((array)$order, $_POST['user_id'], true);
                }
            }
        }

        return json_answer(["data"=>$result ?: null, "auth"=>true]);

    }

}
