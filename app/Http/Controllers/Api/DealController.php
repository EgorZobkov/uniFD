<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class DealController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function checkoutData(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $total_price = 0;
        $total_count = 1;
        $result = [];

        $item = $this->component->ads->getAd((int)$_GET['item_id']);

        if(!$item || $item->delete){
            return json_answer(null);
        }

        if(!$this->component->ads->hasBuySecureDeal($item)){
            return json_answer(null);
        }

        if($item){

            $result = [
                "id"=>$item->id,
                "title"=>$item->title,
                "image"=>$item->media->images->first,
                "type_goods"=>$item->category->type_goods,
                "delivery_list"=>$this->availableDeliveryList($item) ?: null,
            ];

            $total_price = $item->price;

        }

        return json_answer(["data"=>$result, "auth"=>true, "total_price"=>$this->system->amount($total_price)]);

    }

    public function addRecipient(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $answer = [];

        $_POST['phone'] = $_POST['phone'] ? $this->api->decryptAES($_POST['phone']) : '';
        $_POST['email'] = $_POST['email'] ? $this->api->decryptAES($_POST['email']) : '';

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_fd3d253f3f3f100d43224d5b478535df");
        }

        if($this->validation->requiredField($_POST['surname'])->status == false){
            $answer[] = translate("tr_36c44ff6c623302a221cdd0c15767593");
        }

        if($this->validation->requiredField($_POST['middlename'])->status == false){
            $answer[] = translate("tr_9edecbeec49ef52308c6847f50bc4288");
        }

        if($this->validation->isPhone($_POST['phone'])->status == false){
            $answer[] = $this->validation->error;
        }

        if($this->validation->isEmail($_POST['email'])->status == false){
            $answer[] = $this->validation->error;
        }

        if(empty($answer)){

            $data = $this->model->users_delivery_data->find("user_id=?", [$_POST['user_id']]);

            if(!$data){

                $this->model->users_delivery_data->insert(["name"=>$_POST['name'],"surname"=>$_POST['surname'],"patronymic"=>$_POST['middlename'],"phone"=>encrypt($this->clean->phone($_POST['phone'])),"email"=>encrypt($_POST['email']),"user_id"=>$_POST['user_id']]);

            }else{

                $this->model->users_delivery_data->update(["name"=>$_POST['name'],"surname"=>$_POST['surname'],"patronymic"=>$_POST['middlename'],"phone"=>encrypt($this->clean->phone($_POST['phone'])),"email"=>encrypt($_POST['email'])], $data->id);

            }

            return json_answer(["status"=>true, "auth"=>true]);

        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);
        }

    }

    public function availableDeliveryList($ad=[]){
        global $app;

        $result = [];

        if($ad->delivery_status != 1){
            return [];
        }

        if($app->settings->integration_delivery_services_active){
            $data = $app->model->system_delivery_services->getAll("status=? and id IN(".implode(",", $app->settings->integration_delivery_services_active).")", [1]);
        }

        if($data){
            foreach ($data as $key => $value) {
                if($app->component->delivery->hasAvailableDelivery($ad, $value)){
                    $result[] = ["id"=>$value["id"], "name"=>$value["name"]];
                }
            }
        }

        return $result;

    }

    public function getOrder(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$_GET['order_id']){
            return json_answer(null);
        }

        $result = [];
        $history = [];
        $media_history = [];
        $delivery = "";

        $data = $this->model->transactions_deals->find("(operation_id=? or order_id=?) and (from_user_id=? or whom_user_id=?)", [$_GET['order_id'], $_GET['order_id'], $_GET['user_id'], $_GET['user_id']]);

        if(!$data){
            return json_answer(null);
        }

        $data = $this->component->transaction->getDealByOrderId($data->order_id);

        if($data){

            $getHistory = $this->model->transactions_deals_history->sort("id desc")->getAll("order_id=? and (user_id=? or user_id=?)", [$data->order_id, 0, $_GET['user_id']]);

            if($getHistory){
                foreach ($getHistory as $key => $value) {

                    $media_history = [];
                    $media = _json_decode($value["media"]);

                    if($media){
                        foreach ($media as $media_item) {
                            $media_history[] = $this->storage->name($media_item)->host(true)->get();
                        }
                    }

                    $history[] = ["status_name"=>$this->component->transaction->getHistoryCode($value["action_code"])->name, "time_create"=>$this->datetime->outDateTime($value["time_create"]), "comment"=>$value["comment"] ?: null, "media"=>$media_history ?: null];

                }
            }

            if($data->item->category->type_goods == "physical_goods"){
                if($data->delivery_service_id){
                    $delivery = $data->delivery_service->name;
                }else{
                    $delivery = translate("tr_9f2cbe8833e00db205f337df75228893");
                }
            }

            if($data->from_user->id == $_GET['user_id']){
                $chat_token = $this->component->chat->buildToken(["ad_id"=>(int)$data->item->id, "from_user_id"=>intval($_GET['user_id']), "whom_user_id"=>(int)$data->whom_user->id]);
            }else{
                $chat_token = $this->component->chat->buildToken(["ad_id"=>(int)$data->item->id, "from_user_id"=>intval($_GET['user_id']), "whom_user_id"=>(int)$data->from_user->id]);
            }

            if($this->component->ads_categories->categories[$data->item->category_id]["type_goods"] == "partner_link"){
                $modeOrder = "partner_link";
            }elseif($data->item->booking_status){
                $modeOrder = "booking";
            }elseif($this->component->ads->hasBuySecureDeal($data->item)){
                $modeOrder = "deal";
            }

            $booking_order = $this->model->booking_orders->find("order_id=?", [$data->order_id]);

            $result = [
                "id"=>$data->id,
                "order_id"=>(String)$data->order_id,
                "chat_token"=>$chat_token,
                "time_create"=>$this->datetime->outDate($data->time_create),
                "title"=>translate("tr_4d406f4dcd44a95252f06163a3cdcb5e")." ".$this->datetime->outDate($data->time_create)." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$this->system->amount($data->amount),
                "amount"=>$this->system->amount($data->amount),
                "status"=>$data->status_processing,
                "status_name"=>$this->component->transaction->getStatusDeal($data->status_processing)->name,
                "from_user"=>[
                    "id"=>$data->from_user->id,
                    "display_name"=>$this->user->name($data->from_user),
                    "avatar"=>$this->storage->name($data->from_user->avatar)->host(true)->get(),
                ],
                "whom_user"=>[
                    "id"=>$data->whom_user->id,
                    "display_name"=>$this->user->name($data->whom_user),
                    "avatar"=>$this->storage->name($data->whom_user->avatar)->host(true)->get(),
                ],
                "disput"=>null,
                "item"=>$data->item ? [
                    "id"=>$data->item->id,
                    "title"=>$data->item->title,
                    "image"=>$data->item->media->images->first,
                    "count"=>$data->item->count . " " . translate("tr_01340e1c32e59182483cfaae52f5206f") . " " . $this->system->amount($data->item->amount),
                    "booking_status"=>$data->item->booking_status ? true : false,
                ] : null,
                "type_goods"=>$data->item->category->type_goods,
                "delivery"=>$delivery ?: null,
                "history"=>$history ?: null,
                "actions"=>$this->outActionsOrderDeal($data, intval($_GET['user_id'])) ?: null,
                "mode_order" => $modeOrder,
                "booking_order"=> $booking_order ? ["user_name"=>$booking_order->user_name,"user_email"=>decrypt($booking_order->user_email),"user_phone"=>decrypt($booking_order->user_phone), "count_guests"=>$booking_order->count_guests ?: null, "date_start"=>$this->datetime->outDateTime($booking_order->date_start), "date_end"=>$this->datetime->outDateTime($booking_order->date_end), "additional_services"=>$booking_order->additional_services ? array_values(_json_decode($booking_order->additional_services)) : null] : null,
            ];

        }else{
            return json_answer(["status"=>false, "auth"=>true]);
        }

        return json_answer(["status"=>true, "data"=>$result, "auth"=>true]);

    }

    public function cancelOrder(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$_POST['order_id']){
            return json_answer(null);
        }

        if($this->validation->requiredField($_POST['reason'])->status == false){
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_110e7382175b53f7dc9b5939d7eb1e0f")]);
        }else{
            $this->component->transaction->cancelDeal($_POST['order_id'], $_POST['user_id'], $_POST["reason"]);
            return json_answer(["status"=>true, "auth"=>true]);
        }        

    }

    public function changeStatus(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$_POST['order_id']){
            return json_answer(null);
        }

        $this->component->transaction->changeStatusDeal($_POST["order_id"], $_POST['user_id'], $_POST["status"]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function closeDisput(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$_POST['order_id']){
            return json_answer(null);
        }

        $this->component->transaction->changeStatusDeal($_POST["order_id"], $_POST['user_id'], "completed_order");

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function addDisput(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$_POST['order_id']){
            return json_answer(null);
        }

        $attach_files = [];

        $_POST['attach'] = $_POST["attach"] ? _json_decode(html_entity_decode($_POST["attach"])) : [];

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "answer"=>translate("tr_999a9e5388440a8a000821fd63aa6dd5")]);
        }else{

            if($_POST['attach']){

                foreach ($_POST['attach'] as $key => $value) {
                    $attach_files[] = $value["name"];
                }

            }

            $getDeal = $this->model->transactions_deals->find("order_id=? and from_user_id=?", [$_POST["order_id"],$_POST['user_id']]);

            if($getDeal){

                if($attach_files){
                    $attach_files = $this->storage->uploadAttachFiles($attach_files, $this->config->storage->users->attached);
                }

                $this->component->transaction->addDisputeDeal($_POST["order_id"],$_POST['user_id'],$_POST["text"],$attach_files);

            }

            return json_answer(["status"=>true, "auth"=>true]);

        }

    }

    public function outActionsOrderDeal($data=[], $user_id=0){

          $result = [];

          if($data->from_user_id == $user_id){

            if($data->status_processing == "awaiting_confirmation"){

                if(!$data->item->booking_status){
                    $result = ["title"=>translate("tr_adedfabc674e7efd3d316f4111b58a7b"), "buttons"=>[["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];
                }else{
                    $result = ["title"=>translate("tr_140ab83e84e71d7d537f3f334d67bc25"), "buttons"=>[["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];
                }

            }elseif($data->status_processing == "confirmed_order"){

                if(!$data->item->booking_status){

                    if($data->item->category->type_goods == "physical_goods"){
                        if($data->delivery_service_id){
                            $result = ["title"=>translate("tr_49719417c532c5cb93fb1bcfb64a4ccd"), "buttons"=>null];
                        }else{   
                            $result = ["title"=>translate("tr_b5a0e321d5daa89eecb9e461cfd53cc5"), "buttons"=>null];                  
                        }
                    }elseif($data->item->category->type_goods == "services"){
                        $result = ["title"=>translate("tr_abe06f92ce38481cf4e0a13203d2b053"), "buttons"=>null];  
                    }

                }else{

                    $result = ["title"=>translate("tr_c5cb17572975ff74c1988fb85bd1df0a"), "buttons"=>[["name"=>translate("tr_e1f7d614ec62e7651cd1c77c6f3a8afb"), "action"=>"init_payment"], ["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];                   
                }

            }elseif($data->status_processing == "access_open"){

                $result = ["title"=>translate("tr_409c4a591bae436a2f1f192dc3177d4a")." ".$this->settings->secure_deal_auto_closing_time." ".endingWord($this->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")), "buttons"=>[["name"=>translate("tr_49eb66b6229f98e4afbe115b412844fe"), "action"=>"completed"], ["name"=>translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"), "action"=>"disput"]], "external_content"=>$data->item->external_content ? decrypt($data->item->external_content) : null];

            }elseif($data->status_processing == "confirmed_send_shipment"){

                $result = ["title"=>null, "buttons"=>[["name"=>translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"), "action"=>"delivery_history"], ["name"=>translate("tr_88c22e531b9c4cf920aead3329f5bfa6"), "action"=>"completed"], ["name"=>translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"), "action"=>"disput"]], "comment"=>$data->delivery_answer_data["comment_to_recipient"] ?: null, "delivery_service_name"=>$data->delivery_service->name];

            }elseif($data->status_processing == "confirmed_transfer"){

                $result = ["title"=>translate("tr_8518db38f8e990fa9ba83bcc1539d00e")." ".$this->settings->secure_deal_auto_closing_time." ".endingWord($this->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")), "buttons"=>[["name"=>translate("tr_88c22e531b9c4cf920aead3329f5bfa6"), "action"=>"completed"], ["name"=>translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"), "action"=>"disput"]], "track_number"=>$data->delivery_answer_data["track_number"], "delivery_service_name"=>$data->delivery_service->name];

            }elseif($data->status_processing == "confirmed_completion_service"){

                $result = ["title"=>translate("tr_afdfc6e0b45a15e90b586efd5b2adb5b")." ".$this->settings->secure_deal_auto_closing_time." ".endingWord($this->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")), "buttons"=>[["name"=>translate("tr_038001628d0014bc8718b42d1405ea18"), "action"=>"completed"], ["name"=>translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"), "action"=>"disput"]], "track_number"=>$data->delivery_answer_data["track_number"], "delivery_service_name"=>$data->delivery_service->name];

            }elseif($data->status_processing == "completed_order"){

                $infoPayment = $this->api->outInfoPaymentsOrderDeal($data->order_id, $user_id);

                $result = ["title"=>$infoPayment ?: null, "buttons"=>null, "external_content"=>$data->item->external_content ? decrypt($data->item->external_content) : null];

            }elseif($data->status_processing == "open_dispute"){

                $result = ["title"=>translate("tr_572361ee356ac71a2d8b92b04ebcc5e2"), "buttons"=>[["name"=>translate("tr_cbcae031aaf24f2be3b3cd22d4d0fb9b"), "action"=>"close_disput"]]];

            }elseif($data->status_processing == "booked"){

                $result = ["title"=>null, "buttons"=>[["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"], ["name"=>translate("tr_0285fcf16e0e6fc509ba686b22ba3c44"), "action"=>"disput"]]];

            }

          }elseif($data->whom_user_id == $user_id){

            if($data->status_processing == "awaiting_confirmation"){

                if($data->delivery_service_id){

                    if($data->user_shipping){

                        $result = ["title"=>translate("tr_33f03b454585b2ff07d9403c30bb434c"), "buttons"=>[["name"=>translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"), "action"=>"change_status", "status"=>"confirmed_order"], ["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];

                    }else{

                        $result = ["title"=>translate("tr_33f03b454585b2ff07d9403c30bb434c"), "buttons"=>[["name"=>translate("tr_8947979f1038a8bf293854cec9e73b6a"), "action"=>"profile_setttings"], ["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];

                    }

                }else{

                    $result = ["title"=>translate("tr_33f03b454585b2ff07d9403c30bb434c"), "buttons"=>[["name"=>translate("tr_e2603bcce79e0b861ac1f1bd464de2b6"), "action"=>"change_status", "status"=>"confirmed_order"], ["name"=>translate("tr_dc7115d9a6cd6914bd2b1b0fb70fbc4e"), "action"=>"cancel_order"]]];
                }

            }elseif($data->status_processing == "confirmed_order"){

                if($data->item->category->type_goods == "physical_goods"){

                    if(!$data->item->booking_status){
                        if($data->delivery_service_id){

                            $buttons[] = ["name"=>translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"), "action"=>"delivery_history"];
                            $buttons[] = ["name"=>translate("tr_d458374e3228a9c45017b98ff1241e86"), "action"=>"change_status", "status"=>"confirmed_send_shipment"];

                            $result = ["title"=>null, "buttons"=>$buttons, "comment"=>$data->delivery_answer_data["comment_to_sender"] ?: null, "delivery_service_name"=>$data->delivery_service->name, "shipping_point_address"=>$data->user_shipping_point->address];

                        }else{
                            $result = ["title"=>translate("tr_25ff13482d796c27b197ad05d7ed522a"), "buttons"=>[["name"=>translate("tr_eaec2623204b61af4ee3d78d01dae0ce"), "action"=>"execution"]]];                       
                        }
                    }

                }elseif($data->item->category->type_goods == "services"){
                    $result = ["title"=>null, "buttons"=>[["name"=>translate("tr_038001628d0014bc8718b42d1405ea18"), "action"=>"execution"]]]; 
                }

            }elseif($data->status_processing == "access_open"){

                $result = ["title"=>translate("tr_90a74c8fc8c8add56d9524f76cce9fd7")." ".$this->settings->secure_deal_auto_closing_time." ".endingWord($this->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")), "buttons"=>null]; 

            }elseif($data->status_processing == "confirmed_send_shipment"){

                $result = ["title"=>$this->system->amount($this->component->transaction->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)).' '.translate("tr_6f07e1f8fa38e0b51401b846f6d3866c"), "buttons"=>[["name"=>translate("tr_b8a37dd8c44d4f0452cddd609dd614e9"), "action"=>"delivery_history"]]];

            }elseif($data->status_processing == "confirmed_transfer" || $data->status_processing == "confirmed_completion_service"){

                $result = ["title"=>$this->system->amount($this->component->transaction->calculationDealProfitUserPayments($data->amount, $data->delivery_amount)).' '.translate("tr_1eb131f3df87d0b96aa2670c059c1bd7") . ' ' . $this->settings->secure_deal_auto_closing_time . ' ' . endingWord($this->settings->secure_deal_auto_closing_time, translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340")), "buttons"=>null];
 
            }elseif($data->status_processing == "completed_order"){

                $infoPayment = $this->api->outInfoPaymentsOrderDeal($data->order_id, $user_id);

                $result = ["title"=>$infoPayment ?: null, "buttons"=>null];

            }elseif($data->status_processing == "open_dispute"){

                $result = ["title"=>translate("tr_572361ee356ac71a2d8b92b04ebcc5e2"), "buttons"=>null];

            }

          }

          return $result;

    }

}
