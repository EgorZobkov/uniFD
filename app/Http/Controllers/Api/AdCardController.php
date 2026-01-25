<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class AdCardController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getCard(){ 

        $result = [];
        $media = [];
        $video = [];
        $reviews = [];
        $reviewsMedia = [];
        $propertyArray = [];
        $informers = [];
        $property = [];
        $partnerData = [];
        $statusNote = [];
        $paidServices = [];
        $services = [];
        $owner = false;
        $price_currencies = [];
        $remained_available_label = null;

        $ad = $this->component->ads->getAd($_GET['id']);

        if(!$ad || $ad->delete){
            return json_answer(["exist"=>false]);
        }

        if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            if($_GET['user_id'] == $ad->user_id){
                $owner = true;
            }
        }

        $this->component->ads->fixView($_GET['id'], $_GET['user_id']);

        if($ad->link_video){
            $video_link = $this->video->parseLinkSource($ad->link_video);
        }else{
            $video_link = null;
        }

        if($ad->media->inline){
            foreach ($ad->media->inline as $key => $value) {
                $media[] = $value;
            }
        }

        if($ad->media->video->all){
            foreach ($ad->media->video->all as $key => $value) {
                $video[] = ["type"=>"video", "link"=>$value];
            }
        }

        if($video_link){
            $video[] = ["type"=>"video_link", "link"=>$video_link->link, "preview"=>$video_link->image];
            $media[] = ["link"=>$video_link->link, "preview"=>$video_link->image, "type"=>"video_link", "name"=>null];
        }

        $propertyArray = $this->component->ads_filters->outPropertyAd($ad->id, [], true);

        if($propertyArray){
            foreach ($propertyArray as $name => $value) {
                $property[] = ["name"=>$name, "value"=>$value];
            }
        }

        $getReviews = $this->model->reviews->getAll("item_id=? and status=? and parent_id=?", [$_GET['id'], 1, 0]);

        if($getReviews){
            foreach ($getReviews as $key => $value) {
                $reviews[] = $this->api->reviewData($value);
                if($value['media']){
                    $r_media = _json_decode($value['media']);
                    foreach ($r_media as $media_item) {
                        $reviewsMedia[] = ["id"=>$value["id"], "link"=>$this->storage->name($media_item)->host(true)->get(), "text"=>html_entity_decode($value["text"]), "type"=>"image", "ad_id"=>$ad->id, "image"=>$ad->media->images->first, "title"=>$ad->title, "price"=>$this->system->amount($ad->price), "rating"=>$value["rating"]];
                    }
                }
            }
        }

        if($ad->user->verification_status){
            $informers[] = ["id"=>"verification", "image"=>$this->storage->host(true)->getAssetImage("1216566434323535.webp"), "title"=>translate("tr_a311b105835135f4af7badcd9c5d8842"), "desc"=>translate("tr_84e690943a800bb844348787d3822f91")];
        }

        if($ad->booking_status && $this->component->ads_categories->categories[$ad->category_id]["booking_action"] == "booking"){
            $informers[] = ["id"=>"booking", "image"=>$this->storage->host(true)->getAssetImage("1216566434323535.webp"), "title"=>translate("tr_759a0c724d2214d9002ad9b1345e9743"), "desc"=>translate("tr_8008b2f2e6f1541bfe6eb7a9780b1f16")];
        }

        if($ad->online_view_status){
            $informers[] = ["id"=>"online_view", "image"=>$this->storage->host(true)->getAssetImage("11682881434532236326.webp"), "title"=>translate("tr_b25662e0ea7b58a615d25d1dbd762766"), "desc"=>translate("tr_a2788c6a066734ba576cb56d367da5b3")];
        }

        if($ad->delivery_status == 1 && $ad->user->delivery_status){
            $informers[] = ["id"=>"delivery", "image"=>$this->storage->host(true)->getAssetImage("icDev45345634763467.png"), "title"=>translate("tr_c62d9a9729db83c1d8f2de72211c2111"), "desc"=>translate("tr_b90bbcd6e88c43efe24b8bbf512dd596")];
        }

        if($this->component->ads_categories->categories[$ad->category_id]["type_goods"] == "partner_link"){

            $modeOrder = "partner_link";

            $button_title = translate("tr_f9edcc918d2f3fcfd576493dfc442f0d");
            $button_color = '#36b555';

            if($ad->partner_button_name){
                $button_title = $ad->partner_button_name;
            }

            if($ad->partner_button_color){
                $button_color = $ad->partner_button_color;
            }

            $partnerData = ["title"=>$button_title, "color"=>$button_color, "link"=>$ad->partner_link];

        }elseif($ad->booking_status){
            $modeOrder = "booking";
        }elseif($this->component->ads->hasBuySecureDeal($ad)){
            $modeOrder = "deal";
            if($ad->not_limited == 0){
                if($ad->in_stock == 0 || $ad->in_stock == 1){
                    $remained_available_label = null;
                }elseif($ad->in_stock < 10){
                    $remained_available_label = translate("tr_496e3a1c076663f2e5a7fae281ae6d56");
                }
            }
        }

        if($ad->reason_blocking_code){
            $statusNote = $this->system->getReasonBlocking($ad->reason_blocking_code);
        }

        $getOrders = $this->model->ads_services_orders->getAll("ad_id=?", [$ad->id]);
        if($getOrders){
            foreach ($getOrders as $key => $value) {

                $service = $this->model->ads_services->find("id=?", [$value["service_id"]]);
                if($service){

                    $progress = ((time() - strtotime($value["time_create"])) / (strtotime($value["time_expiration"]) - strtotime($value["time_create"]))) * 10;

                    if($progress >= 100 || $progress >= 10){
                        $progressLine = '1.0';
                    }else{
                        $progressLine = '0.' . str_replace('.', '' , $progress);
                    }

                    $paidServices[] = ["name"=>$service->name, "progress"=>$progressLine , "date"=>$this->datetime->outStringDiff(null,$value["time_expiration"])];

                }

            }
        }

        if(false){
            $price_currencies[] = ["price"=>0, "symbol"=>"", "price_by_currency"=>""];
        }

        $result = [
            "owner"=>$owner,
            "chat_token"=>intval($_GET['user_id']) ? $this->component->chat->buildToken(["ad_id"=>$ad->id, "from_user_id"=>intval($_GET['user_id']), "whom_user_id"=>$ad->user_id]) : null,
            "exist"=>true,
            "active_status"=>$ad->status == 1 ? true : false,
            "id" => $ad->id,
            "status" => (int)$ad->status,
            "status_note" => $statusNote ? $statusNote->text : null,
            "title" => html_entity_decode($ad->title),
            "contact_method"=>$ad->contact_method ?: "all",
            "link" => $this->component->ads->buildAliasesAdCard($ad),
            "video_link" => $video_link ? $video_link->link : null,
            "price" => $this->api->price(["ad"=>$ad]),
            "price_currencies" => $price_currencies ?: null,
            "address_latitude" => $ad->address_latitude ?: null,
            "address_longitude" => $ad->address_longitude ?: null,
            "text" => html_entity_decode($ad->text),
            "address" => $ad->address ? html_entity_decode($ad->address) : null,
            "city_area"=> $ad->geo ? $value->geo->name : null,
            "media" => $media ?: null,
            "video" => $video ?: null,
            "count_images" => count($media),
            "count_view" => (int)$this->component->ads->getViews($ad->id),
            "count_view_today" => (int)$this->component->ads->getViewsToday($ad->id),
            "online_view" => $ad->online_view_status ? true : false,
            "time_create" => $this->datetime->outLastTime($ad->time_create),
            "property" => $property ?: null,
            "informers" => $informers ?: null,
            "services" => $paidServices ?: null,
            "in_favorites" => $this->model->users_favorites->find("ad_id=? and user_id=?", [$ad->id, (int)$_GET['user_id']]) ? true : false,
            "button_added_services_tariffs" => $available_services_ids ? true : false,
            "reviews" => $reviews ?: null,
            "reviews_media" => $reviewsMedia ?: [],
            "reviews_preview_index" => $reviews ? count($reviews)-1 : null,
            "category_paid_price" => $this->system->amount($this->component->ads_categories->categories[$ad->category_id]["paid_cost"]),
            "category_paid_count_free" => $this->component->ads_categories->categories[$ad->category_id]["paid_free_count"],
            "secure_status" => $this->component->ads->hasBuySecureDeal($ad),
            "booking" => [
                "status" => $ad->booking_status,
                "variant" => $this->component->ads_categories->categories[$ad->category_id]["booking_action"],
            ],
            "delivery_status" => $ad->delivery_status == 1 && $ad->user->delivery_status ? true : false,
            "user" => $this->api->userData($ad->user),
            "remained_available_label" => $remained_available_label,
            "available" => $ad->in_stock,
            "available_unlimitedly" => $ad->not_limited ? true : false,
            "available_status" => $this->api->adAvailableStatus($ad->not_limited, $ad->in_stock) ? true : false,
            "cart_status" => $this->component->ads->hasAddToCart($ad),
            "mode_order" => $modeOrder,
            "partner_link" => $partnerData ?: null,
            "condition_status" => $ad->condition_new_status ? true : false,
            "total_rating" => sprintf("%.1f", $ad->total_rating),
            "total_reviews" => $ad->total_reviews,
        ];

        return json_answer($result);

    }

    public function getContacts(){ 

        if($this->settings->board_card_who_phone_view == "auth"){
            if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
                return json_answer(["auth"=>false]);
            }else{
                if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "view_contacts")){
                    return json_answer(["verification"=>false, "auth"=>true]);
                }
            }
        }

        $result = [];
        $messengers = []; 

        $ad = $this->component->ads->getAd($_POST['id']);

        if(!$ad){
            return json_answer(null);
        }

        if($ad->status != 1 || $ad->block_forever_status){
             return json_answer(null);
        }

        $ad->contacts->name = $ad->contacts->name ?: $ad->user->name;
        $ad->contacts->phone = $ad->contacts->phone ?: $ad->user->phone;

        if($ad->contacts->max && $this->settings->board_publication_required_contact_max){
            $messengers[] = ["name"=>"Max", "image"=>$this->storage->name("social/max.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("https://web.max.ru/".$ad->contacts->max)];
        }

        if($ad->contacts->telegram && $this->settings->board_publication_required_contact_telegram){
            $messengers[] = ["name"=>"Telegram", "image"=>$this->storage->name("social/tg.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("tg://resolve?domain=".$ad->contacts->telegram)];
        }

        if($ad->contacts->whatsapp && $this->settings->board_publication_required_contact_whatsapp){
            $messengers[] = ["name"=>"WhatsApp", "image"=>$this->storage->name("social/wa.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("whatsapp://send?phone=".$ad->contacts->whatsapp)];
        }

        if($ad->contacts->phone){
            if($this->settings->phone_add_plus_status){
                $ad->contacts->phone = "+" . trim($ad->contacts->phone, "+");
            }
        }

        $result = [
            "name"=>$ad->contacts->name,
            "phone"=>$this->api->encryptAES($ad->contacts->phone) ?: null,
            "email"=>$ad->contacts->email && $this->settings->board_publication_required_email ? $this->api->encryptAES($ad->contacts->email) : null,
            "messengers"=>$messengers ?: null,
        ];

        return json_answer(["data"=>$result, "auth"=>true, "verification"=>true]);

    }

    public function getSimilars(){ 

        $result = [];

        $ad = $this->component->ads->getAd($_GET['id']);

        if(!$ad){
            return json_answer(null);
        }

        if($ad->user->service_tariff->items->hiding_competitors_ads){
            $data = $this->model->ads_data->sort("id desc")->getAll("user_id=? and status=? and id!=?", [$ad->user_id,1,$ad->id]);
            $title = translate("tr_f6f59e47a711dada3fd8aa7bc2d393ef");
        }else{
            $data = $this->model->ads_data->sort("id desc")->getAll("category_id IN(".$this->component->ads_categories->joinId($ad->category_id)->getParentIds($ad->category_id).") and status=? and id!=?", [1,$ad->id]);
            $title = translate("tr_b74483c9a23e5518e3175cff4544e1ae");
        }

        if($data){

            shuffle($data);

            foreach (array_slice($data, 0, 20) as $key => $value) {
               
                $value = $this->component->ads->getDataByValue($value);

                $result[] = $this->api->adData($value);

            }
        }

        return json_answer(["data"=>$result, "title"=>$title]);

    }

    public function addComplaint(){ 

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($this->validation->requiredField($_POST['text'])->status == false){
            return json_answer(["status"=>false, "answer"=>translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5"), "auth"=>true]);
        }else{

            $data = $this->component->ads->getAd($_POST["id"]);

            if($data && !$data->delete){

                if(!$this->model->complaints->find("from_user_id=? and item_id=? and status=?", [$_POST['user_id'],$_POST["id"],0])){
                    $this->model->complaints->insert(["from_user_id"=>$_POST['user_id'],"text"=>$_POST["text"],"item_id"=>$_POST["id"],"whom_user_id"=>$data->user_id,"time_create"=>$this->datetime->getDate()]);
                    $this->event->addComplaintAd(["from_user_id"=>$_POST['user_id'], "whom_user_id"=>$data->user_id, "text"=>$_POST["text"], "item_id"=>$_POST["id"]]);
                }

            }

        } 

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function goPartnerLink(){

        if($this->settings->board_card_who_transition_partner_link == "auth"){

            if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
                return json_answer(["auth"=>false]);
            }

        }

        $ad = $this->model->ads_data->find("id=?", [$_POST['id']]);

        if($ad){
            if($ad->partner_link){
                $this->event->goPartnerLink(["from_user_id"=>$_POST['user_id'], "ad_id"=>$_POST['id']]);
                return json_answer(["link"=>$ad->partner_link, "auth"=>true, "status"=>true]);
            }
        }
        
    }

    public function deleteAd(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->component->ads->delete($_POST["id"], $_POST['user_id']);

        return json_answer(["auth"=>true, "status"=>true]);
        
    }

    public function changeStatus(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $ad = $this->model->ads_data->find("id=? and user_id=?", [$_POST['id'], $_POST['user_id']]);

        if($ad->status != 0){
            $this->model->ads_data->update(["status"=>(int)$_POST['status']], $ad->id);
        }

        return json_answer(["auth"=>true, "status"=>true]);
        
    }

    public function getServicesTariffsAll(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $getActiveServices = $this->component->ad_paid_services->getActiveServicesByAd($_GET['id']);

        if($getActiveServices->ids){
            $data = $this->model->ads_services->sort("recommended desc, sorting asc")->getAll("status=? and alias!=?", [1, "package"]);
        }else{
            $data = $this->model->ads_services->sort("recommended desc, sorting asc")->getAll("status=?", [1]);
        }

        if($data){

            foreach ($data as $key => $value) {

                $connected = false;

                if($getActiveServices->data_by_alias["package"]){
                    $connected = true;
                }else{
                    $connected = compareValues($getActiveServices->ids, $value["id"]) ? true : false;
                }

                $result[] = [
                    "id" => $value["id"],
                    "name" => html_entity_decode($value["name"]),
                    "image" => $value["image"] ? $this->storage->name($value["image"])->host(true)->get() : null,
                    "price" => $value["old_price"] ? ["now"=>$value["price"], 'old'=>$value["old_price"]] : ["now"=>$value["price"], "old"=>null],
                    "text" => html_entity_decode($value["text"]),
                    "variant" => $value["count_day_fixed"] ? 'fix' : 'change',
                    "count_day" => translate("tr_e73bef6ffbaf33e11595b0a4c1639a44")." ".$value["count_day"]." ".endingWord($value["count_day"], translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"), translate("tr_0871eeafdf38726742fa5affa8a5d6eb"), translate("tr_c183655a02377815e6542875555b1340")),
                    "connected" => $connected,
                    "recommended" => $value["recommended"] ? true : false,
                    "package_status" => $value["package_status"] ? true : false,
                    "alias" => $value["alias"],
                ];

            }

        }

        return json_answer(["auth"=>true, "data"=>$result]);
        
    }


}