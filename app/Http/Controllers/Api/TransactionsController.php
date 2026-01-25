<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class TransactionsController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function initPayment(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($_POST["target"] == "user_balance"){

            $result = $this->component->transaction->initPaymentWallet(["payment_id"=>$_POST["payment_id"], "amount"=>$_POST["amount"]], $_POST['user_id']);

        }elseif($_POST["target"] == "item"){

            if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "create_order")){
                return json_answer(["verification"=>false, "auth"=>true]);
            }

            $result = $this->component->transaction->initPaymentItem($_POST["id"], (int)$_POST["delivery_point_id"], $_POST['user_id']);

        }elseif($_POST["target"] == "order"){

            if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "create_order")){
                return json_answer(["verification"=>false, "auth"=>true]);
            }

            $result = $this->component->transaction->initPaymentOrder($_POST["id"], $_POST['user_id']);

        }elseif($_POST["target"] == "cart"){

            if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "create_order")){
                return json_answer(["verification"=>false, "auth"=>true]);
            }

            $delivery_points = $_POST["delivery_points"] ? _json_decode(html_entity_decode($_POST["delivery_points"])) : [];
            $points = [];
            $items_id = [];

            if($delivery_points){
                foreach ($delivery_points as $key => $value) {
                    if(intval($value["id"]) && intval($value["point_id"])){
                        $points[(int)$value["id"]] = (int)$value["point_id"];
                    }
                }
            }

            $cart = $this->model->cart->getAll("user_id=?", [$_POST['user_id']]);
            if($cart){
                foreach ($cart as $key => $value) {
                    $items_id[] = $value["id"];
                }
            }

            $result = $this->component->transaction->initPaymentCart($items_id, $points, $_POST['user_id']);

        }else{

            if($_POST["target"] == "paid_ad_services"){
                $_POST['count_day'][$_POST['service_id']] = (int)$_POST['count_day'];
            }

            $result = $this->component->transaction->initPaymentTarget($_POST["payment_id"], $_POST ? $_POST : [], $_POST['user_id']);

        }

        if($result["status"]){
            return json_answer(["status"=>true, "auth"=>true, "link"=>$result["link"] ?: null, "order_id"=>$result["order_id"] ?: null, "verification"=>true]);
        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>$result["answer"], "verification"=>true]);
        }

    }

    public function statusPayment(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $data = [];

        if($_POST['order_id']){
            $data = $this->model->transactions_operations->find("order_id=? and user_id=? and status_processing=?", [$_POST['order_id'], (int)$_POST['user_id'], "paid"]);
        }

        if($data){
            return json_answer(["status"=>true, "auth"=>true, "order_id"=>$_POST["order_id"] ?: null]);
        }else{
            return json_answer(["status"=>false, "auth"=>true]);
        }

    }


}