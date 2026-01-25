<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class TransactionsController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addPaymentScoreUser()
{   

    if($this->validation->requiredField($_POST['score'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_d3d05547a7366b773ccc9138621d1d2b")]);
    }else{
        $result = $this->component->transaction->addPaymentScoreUser($_POST['order_id'], $this->user->data->id, $_POST["score"]);
        return json_answer($result);
    }

}

public function buyItemCard($id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/transaction.js\" type=\"module\" ></script>"]);

    $data["ad"] = $this->component->ads->getAd($id);

    if($data["ad"]){
        if(!$this->component->ads->hasBuySecureDeal($data["ad"])){
            abort(404);
        }
    }else{
        abort(404);
    }

    return $this->view->render('order/buy', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_f50d065821e1d997a32ec402f29cf6ea")]]);

}

public function cancelDeal()
{   

    if($this->validation->requiredField($_POST['reason'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_110e7382175b53f7dc9b5939d7eb1e0f")]);
    }else{
        $this->component->transaction->cancelDeal($_POST['order_id'], $this->user->data->id, $_POST["reason"]);
        return json_answer(["status"=>true]);
    }

}

public function changeStatusDeal()
{   

    $result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, $_POST["status"]);

    return json_answer($result);

}

public function disputeAdd()
{   

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_999a9e5388440a8a000821fd63aa6dd5")]);
    }else{

        $getDeal = $this->model->transactions_deals->find("order_id=? and from_user_id=?", [$_POST["order_id"],$this->user->data->id]);

        if($getDeal){

            $attach_files = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);

            $this->component->transaction->addDisputeDeal($_POST["order_id"],$this->user->data->id,$_POST["text"],$attach_files);

        }

        return json_answer(["status"=>true]);

    }

}

public function disputeClose()
{   

    $result = $this->component->transaction->changeStatusDeal($_POST["id"], $this->user->data->id, "completed_order");

    return json_answer($result);

}

public function disputeUploadAttach()
{   

    $result = '';

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $result = '
          <div class="uni-attach-files-item-delete uniAttachFilesDeleteItem" ><i class="ti ti-x"></i></div>
          <img class="image-autofocus" src="'.$this->storage->name($resultUpload["name"])->path('temp')->get().'" />
          <input type="hidden" name="attach_files[]" value="'.$resultUpload["name"].'" >
        ';

    }

    return json_answer(["content"=>$result]);

}

public function initPaymentItem()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $result = $this->component->transaction->initPaymentItem($_POST["id"], $_POST["delivery_point_id"], $this->user->data->id);

    return json_answer($result);

}

public function initPaymentOrder()
{   

    if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_order")){
        return json_answer(["verification"=>false]);
    }

    $result = $this->component->transaction->initPaymentOrder($_POST["id"], $this->user->data->id);

    return json_answer($result);

}

public function initPaymentTarget()
{

    $result = $this->component->transaction->initPaymentTarget($_POST["payment_id"], $_POST["params"] ?_json_decode(urldecode($_POST["params"])) : [], $this->user->data->id);

    return json_answer($result);

}

public function initPaymentWallet()
{

    $result = $this->component->transaction->initPaymentWallet($_POST, $this->user->data->id);

    return json_answer($result);

}

public function loadPaymentOption()
{

    return json_answer(['content'=>$this->component->transaction->optionsPayment($_POST["params"] ?_json_decode(urldecode($_POST["params"])) : $_POST)]);

}

public function orderCard($order_id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/transaction.js\" type=\"module\" ></script>"]);

    $data = $this->component->transaction->getDealByOrderId($order_id);

    if($data){
        if($data->from_user_id != $this->user->data->id && $data->whom_user_id != $this->user->data->id){
            abort(404);
        }
    }else{
        abort(404);
    }

    $data->payment_service = $this->component->transaction->getServiceSecureDeal();

    if($data->item->booking_status){

        $data->order = $this->model->booking_orders->find("order_id=?", [$data->order_id]);

        return $this->view->render('order/card-booking', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_dad1404ddfa1a8ad48138c0765544fbb").$order_id]]);
        
    }else{
        return $this->view->render('order/card', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_dad1404ddfa1a8ad48138c0765544fbb").$order_id]]);
    }
    
}

public function paymentStatusFail()
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = [];
    return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_94848568e6805b1081f23272106f9548")]]);
    
}

public function paymentStatusOrder($order_id=null)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = $this->component->transaction->getOperation($order_id);

    if(!$order){
        return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_39747e975806eaa650385b84f760cb92")]]);
    }else{
        if($order->status_processing == "awaiting_payment"){
            return $this->view->render('payment/awaiting_payment', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_be476b6da31948fbd3fcb3021718cfb6")]]);
        }elseif($order->status_processing == "paid"){
            return $this->view->render('payment/success', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_1ec8bd15c6af4d32aea09b6e7ad4f1f3")]]);
        }elseif($order->status_processing == "awaiting_refund"){
            return $this->view->render('payment/awaiting_refund', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_fec1f30fcfe956fed8f5f2b5446abd10")]]);
        }elseif($order->status_processing == "refund"){
            return $this->view->render('payment/refund', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_8c5fa79d745ebec6136f766f37ffacbe")]]);
        }elseif($order->status_processing == "error"){
            return $this->view->render('payment/fail', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_c6fd3c6a629b51b28c19e8495994f4ca")]]);
        }
    }

}

public function paymentStatusSuccess()
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $order = [];
    return $this->view->render('payment/success', ["order"=>(object)$order, "seo"=>(object)["meta_title"=>translate("tr_fa136a673115aa595edcd74288abdbc1")]]);
    
}

public function saveDeliveryRecipient()
{   

    $answer = [];

    if($this->validation->requiredField($_POST['delivery_recipient_name'])->status == false){
        $answer['delivery_recipient_name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['delivery_recipient_surname'])->status == false){
        $answer['delivery_recipient_surname'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['delivery_recipient_patronymic'])->status == false){
        $answer['delivery_recipient_patronymic'] = $this->validation->error;
    }

    if($this->validation->isEmail($_POST['delivery_recipient_email'])->status == false){
        $answer['delivery_recipient_email'] = $this->validation->error;
    }

    if($this->validation->isPhone($_POST['delivery_recipient_phone'])->status == false){
        $answer['delivery_recipient_phone'] = $this->validation->error;
    }

    if(empty($answer)){

        $data = $this->model->users_delivery_data->find("user_id=?", [$this->user->data->id]);

        if(!$data){

            $this->model->users_delivery_data->insert(["name"=>$_POST['delivery_recipient_name'],"surname"=>$_POST['delivery_recipient_surname'],"patronymic"=>$_POST['delivery_recipient_patronymic'],"phone"=>encrypt($this->clean->phone($_POST['delivery_recipient_phone'])),"email"=>encrypt($_POST['delivery_recipient_email']),"user_id"=>$this->user->data->id]);

        }else{

            $this->model->users_delivery_data->update(["name"=>$_POST['delivery_recipient_name'],"surname"=>$_POST['delivery_recipient_surname'],"patronymic"=>$_POST['delivery_recipient_patronymic'],"phone"=>encrypt($this->clean->phone($_POST['delivery_recipient_phone'])),"email"=>encrypt($_POST['delivery_recipient_email'])], $data->id);

        }

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}



 }