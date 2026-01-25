<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ProfileController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){   
    
        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $user = $this->model->users->findById($_GET['user_id']);

        if($user){
            return json_answer($this->api->userFullData($user));
        }

        return json_answer([]);

    }

    public function getAllTariffs(){   

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $tempResult = [];

        $user = $this->model->users->find("id=?", [$_GET['user_id']]);

        $tariffs = $this->model->users_tariffs->getAll("status=? order by sorting asc", [1]);

        if($tariffs){

            foreach ($tariffs as $key => $value) {

                $items = [];

                if(_json_decode($value["items_id"])){

                    $items_ids = implode(",", _json_decode($value["items_id"]));

                    $getItems = $this->model->users_tariffs_items->getAll("id IN(".$items_ids.")", []);
                    if($getItems){
                        foreach ($getItems as $item_key => $item_value) {
                            $items[] = ["name"=>translateFieldReplace($item_value, "name", $_REQUEST["lang_iso"]), "text"=>translateFieldReplace($item_value, "text", $_REQUEST["lang_iso"]) ?: null];
                        }
                    }
                }

                if($value["count_day_fixed"]){

                    $days_string = translate("tr_1f6c150ae7fba44b3897f51c51c4ca47").' '.$value['count_day'].' '.endingWord($value['count_day'],translate("tr_48e438a146f96b54bbe9d5046ffc3a2b"),translate("tr_0871eeafdf38726742fa5affa8a5d6eb"),translate("tr_c183655a02377815e6542875555b1340"));

                }else{

                    $days_string = translate("tr_2b6bb2514468aa5ed269cf75ce1e0694");

                }

                $tempResult[$value['id']] = [
                    "id" => $value['id'],
                    "name" => translateFieldReplace($value, "name", $_REQUEST["lang_iso"]),
                    "image" => $value["image"] ? $this->storage->name($value["image"])->host(true)->get() : null,
                    "price" => $value["old_price"] ? ['now'=>$value["price"], 'old'=>$value['old_price']] : ['now'=>$value["price"], 'old'=>null],
                    "text" => translateFieldReplace($value, "text", $_REQUEST["lang_iso"]),
                    "days" => $value['count_day'],
                    "days_string" => $days_string,
                    "items" => $items ?: null,
                    "recommended" => $value["recommended"] ? false : true
                ];

            }

            if($user->tariff_id){

                $tempTariff = $tempResult[$user->tariff_id];

                if($tempTariff){
                    unset($tempResult[$user->tariff_id]);
                    $result[] = $tempTariff;
                }

            }

            foreach ($tempResult as $key => $value) {
                $result[] = $value;
            }

        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function tariffDelete(){   
    
        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->users_tariffs_orders->delete("user_id=?", [$_POST['user_id']]);
        $this->model->users->update(["tariff_id"=>0], $_POST['user_id']);
        $this->model->shops->update(["status"=>"blocked"], ["user_id=?", [$_POST['user_id']]]);

        return json_answer(["status"=>true]);

    }

    public function favoritesManage(){   
    
        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $get = $this->model->users_favorites->find("ad_id=? and user_id=?", [$_POST["ad_id"], $_POST["user_id"]]);

        if($get){

            $this->model->users_favorites->delete("id=?", [$get->id]);

            return json_answer(["status"=>false]);

        }else{

            $ad = $this->component->ads->getAd($_POST["ad_id"]);

            if($ad && !$ad->delete){

                $params = ["user_id"=>$_POST["user_id"], "ad_id"=>$_POST["ad_id"], "time_create"=>$this->datetime->getDate()];

                $this->model->users_favorites->insert($params);

                $this->event->addToFavorite(["user_id"=>$_POST["user_id"], "ad_id"=>$_POST["ad_id"]]);

            }

            return json_answer(["status"=>true]);

        }

    }

    public function getAllAds(){ 

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $data = [];

        $page = (int)$_GET["page"] ? (int)$_GET["page"] : 1;

        if($_GET["sorting"] == "active"){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status=?", [intval($_GET["user_id"]),1]);
        }elseif($_GET["sorting"] == "sold"){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status=?", [intval($_GET["user_id"]),7]);
        }elseif($_GET["sorting"] == "moderation"){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status=?", [intval($_GET["user_id"]),0]);
        }elseif($_GET["sorting"] == "waiting_payment"){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status=?", [intval($_GET["user_id"]),5]);
        }elseif($_GET["sorting"] == "archive"){
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=? and status=?", [intval($_GET["user_id"]),8]);
        }else{
            $data = $this->model->ads_data->pagination(true)->page($page)->output(50)->sort("id desc")->getAll("user_id=?", [intval($_GET["user_id"])]);
        }

        if($data){

            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $result[] = $this->api->adData($value);

            }

        }

        return json_answer(["data"=>$result ?: null, "pages"=>$this->pagination->totalPages, "auth"=>true]);

    }

    public function editStatusText(){

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        if($_POST["text"]){
            $this->model->users->update(["card_status_text"=>$_POST["text"]], $_POST["user_id"]);
        }else{
            $this->model->users->update(["card_status_text"=>null], $_POST["user_id"]);
        }

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function getBalanceHistory(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $data = $this->model->transactions->sort("id desc")->getAll("user_id=? and status_payment=?", [$_GET["user_id"],1]);

        if($data){

            foreach ($data as $key => $value) {
                $result[] = [
                    "name"=>$this->component->transaction->getTitleByTemplateAction(_json_decode(decrypt($value["data"]))),
                    "amount"=>$this->system->amount($value["amount"], $value["currency_code"]),
                    "time_create"=>$this->datetime->outDateTime($value["time_create"]),
                ];
            }

        }

        return json_answer(["data"=>$result ?: null, "auth"=>true]);

    }

    public function getVerificationData(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $user = $this->model->users->find("id=?", [$_GET["user_id"]]);

        $data = $this->model->users_verifications->find("user_id=?", [$_GET["user_id"]]);

        $result = [
            "email" => $user->email ? true : false,
            "phone" => $user->phone ? true : false,
            "data" => (array)$data ?: null,
        ];

        return json_answer(["data"=>$result ?: null, "auth"=>true]);

    }

    public function addVerification(){

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $attach = [];

        $user = $this->model->users->find("id=?", [$_POST["user_id"]]);

        if(!$user->phone){
            $answer[] = translate("tr_d817ba992bb0e66e0cc7d881cc20b3d7");
        }

        if(!$user->email){
            $answer[] = translate("tr_a23bf8ca60fd96fbbe314a0f57607ed7");
        }

        if($_POST["attach"]){
            if(_json_decode(htmlspecialchars_decode($_POST["attach"]))){
                
                foreach (_json_decode(htmlspecialchars_decode($_POST["attach"])) as $key => $value) {
                    $attach[] = $value["name"];
                }

            }else{
                $answer[] = translate("tr_c1ceac7d2dceaa0c7a340ba970f44e10");
            }
        }else{
            $answer[] = translate("tr_c1ceac7d2dceaa0c7a340ba970f44e10");
        }

        if(!intval($_POST["code"])){
            $answer[] = translate("tr_bcb47d39fe2151d975d7f9d13fe8fb4e");
        }

        if(empty($answer)){

            $attach = $this->storage->uploadAttachFiles($attach, $this->config->storage->users->attached);

            $this->model->users_verifications->insert(["time_create"=>$this->datetime->getDate(), "user_id"=>$_POST["user_id"], "media"=>_json_encode($attach), "status"=>"awaiting_verification", "uniq_code"=>(int)$_POST["code"]]);

            $this->event->sendUserVerification(["user_id"=>$_POST["user_id"]]);

            return json_answer(["status"=>true, "auth"=>true]);
        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);
        }

    }

    public function getSchedulerItems(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $data = $this->model->ads_data->getAll("auto_renewal_status=? and user_id=?", [1,$_GET["user_id"]]);

        if($data){
            foreach ($data as $key => $value) {

                $media = $this->component->ads->getMedia($value["media"]);

                $result[] = [
                    "id"=>$value["id"],
                    "title"=>$value["title"],
                    "image"=>$media->images->first,
                    "status"=>$value["status"],
                    "status_name"=>$this->api->statusNameAd($value["status"]),
                ];

            }
        }

        return json_answer(["data"=>$result ?: null, "auth"=>true]);

    }

    public function deleteSchedulerItem(){

        if(!$this->api->verificationAuth($_POST["token"], $_POST["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $this->model->ads_data->update(["auto_renewal_status"=>0], ["user_id=? and id=?", [$_POST["user_id"], (int)$_POST["id"]]]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function getOrders(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        if($_GET['sorting'] == "buy"){

            $getOrders = $this->model->transactions_deals->sort("time_update desc")->getAll("from_user_id=?", [$_GET["user_id"]]);

        }elseif($_GET['sorting'] == "sell"){
            
            $getOrders = $this->model->transactions_deals->sort("time_update desc")->getAll("whom_user_id=?", [$_GET["user_id"]]);

        }else{

            $getOrders = $this->model->transactions_deals->sort("time_update desc")->getAll("from_user_id=?", [$_GET["user_id"]]);

        }

        if($getOrders){
            foreach ($getOrders as $key => $value) {
               
                $value = $this->component->transaction->getDataDealByValue($value);

                 $button_add_review_status = false;
                 $whom_user_id_review = 0;

                 if(($value->status_processing == "completed_order" || $value->status_processing == "cancel_order")){

                    $button_add_review_status = true;

                    if($value->from_user_id == $_GET["user_id"]){
                        $whom_user_id_review = $value->whom_user_id;
                    }else{
                        $whom_user_id_review = $value->from_user_id;
                    }

                 }

                $result[] = [
                    "id"=>$value->id,
                    "button_add_review_status"=>$button_add_review_status,
                    "whom_user_id_review"=>$whom_user_id_review,
                    "order_id"=>$value->order_id,
                    "title"=>"Заказ на сумму ".$this->system->amount($value->amount),
                    "time_create"=>$this->datetime->outDate($value->time_create),
                    "status"=>$value->status_processing,
                    "status_name"=>$this->component->transaction->getStatusDeal($value->status_processing)->name,
                    "from_user_id"=>$value->from_user_id,
                    "whom_user_id"=>$value->whom_user_id,
                ];

            }
        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function getFavorites(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $favorites = [];
        $searches = [];

        $getFavorites = $this->model->users_favorites->sort("id desc")->getAll("user_id=?", [$_GET["user_id"]]);

        if($getFavorites){
            foreach ($getFavorites as $key => $value) {

                $ad = $this->component->ads->getAd($value["ad_id"]);
               
                $favorites[] = [
                    "id"=>$value["id"],
                    "ad_id"=>$value["ad_id"],
                    "title"=>$ad->title,
                    "image"=>$ad->media->images->first,
                    "status"=>$ad->status,
                    "status_name"=>$this->api->statusNameAd($ad->status),
                ];

            }
        }

        $getSearches = $this->model->users_searches->sort("time_create desc")->getAll("user_id=?", [$_GET["user_id"]]);

        if($getSearches){
            foreach ($getSearches as $key => $value) {

                $title = "";

                $params = [];
                $geo = [];
                $geo_data = [];
                $category = [];

                if($value["category_id"]){
                    $category = $this->component->ads_categories->categories[$value["category_id"]];
                    if($category){
                        $category["chain"] = $this->component->ads_categories->chainCategory($value["category_id"]);
                    }
                }

                if($value["city_id"]){
                    $geo = $this->model->geo_cities->find("id=?", [$value["city_id"]]);
                    if($geo){
                        $geo_data = ["geo_name"=>"city", "id"=>$geo->id, "lat"=>$geo->latitude, "lon"=>$geo->longitude, "name"=>$geo->name, "declension"=>$geo->declension];
                    }
                }elseif($value["region_id"]){
                    $geo = $this->model->geo_regions->find("id=?", [$value["region_id"]]);
                    if($geo){
                        $geo_data = ["geo_name"=>"region", "id"=>$geo->id, "name"=>$geo->name, "declension"=>$geo->declension];
                    }
                }elseif($value["country_id"]){
                    $geo = $this->model->geo_countries->find("id=?", [$value["country_id"]]);
                    if($geo){
                        $geo_data = ["geo_name"=>"country", "id"=>$geo->id, "name"=>$geo->name, "declension"=>$geo->declension];
                    }
                }

                $value["params"] = $value["params"] ? _json_decode($value["params"]) : [];

                if(!$value["params"]["search"]){
                    $params = $this->api->buildFiltersApp($value["params"]["filter"]);
                }else{
                    $params["search"] = $value["params"]["search"];
                }

                if($category["chain"]){
                  $title = $category["chain"]->chain_build;
                }elseif($geo){
                  $title = $geo->name;
                }else{
                  $title = translate("tr_9a73b1e5b44bee481ab175b7e327451e");
                } 

                $subtitle = $this->component->catalog->buildChainNamesFilters($value["params"], $geo);

                $searches[] = [
                    "id"=>$value["id"],
                    "params"=>$params ?: null,
                    "title"=>$title,
                    "subtitle"=>$subtitle ?: translate("tr_ad84f1c208c00f5505b5c3d763962964"),
                    "category"=>$category ? ["id"=>$category["id"], "name"=>$category["name"], "breadcrumb"=>$category["chain"]->chain_build] : null,
                    "geo"=>$geo_data ?: null,
                ];

            }
        }

        return json_answer(["favorites"=>$favorites, "searches"=>$searches, "auth"=>true]);

    }

    public function deleteFavorite(){   
    
        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->users_favorites->delete("id=? and user_id=?", [(int)$_POST['id'], (int)$_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function deleteSearch(){   
    
        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->users_searches->delete("id=? and user_id=?", [(int)$_POST['id'], (int)$_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function getSubscriptions(){

        if(!$this->api->verificationAuth($_GET["token"], $_GET["user_id"])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $getSubscriptions = $this->model->users_subscriptions->sort("id desc")->getAll("user_id=?", [$_GET["user_id"]]);

        if($getSubscriptions){
            foreach ($getSubscriptions as $key => $value) {

                $user = $this->model->users->find("id=?", [$value["whom_user_id"]]);
                $shop = $this->component->shop->getActiveShopByUserId($value["whom_user_id"]);

                $result[] = [
                    "id"=>$value["id"],
                    "user_id"=>$value["whom_user_id"],
                    "avatar"=>$this->storage->name($user->avatar ? $user->avatar : null)->host(true)->get(),
                    "display_name"=>$user ? $this->user->name($user) : translate("tr_d4fa6456afc4e0742bcd2e86bbcfb32c"),
                    "shop" => $shop ? [
                        "id"=>$shop->id,
                        "title"=>$shop->title,
                        "logo"=>$app->storage->name($shop->image)->host(true)->get(),
                    ] : null,
                ];

            }
        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function deleteSubscription(){   
    
        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->users_subscriptions->delete("id=? and user_id=?", [(int)$_POST['id'], (int)$_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function editPassword(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $answer = [];

        $user = $this->model->users->find("id=?", [$_POST['user_id']]);

        if($user->password){

            if($this->validation->requiredField($_POST['old_pass'])->status == false){
                $answer[] = translate("tr_04df40a61c5c0794f9b6ad89b3d19822");
            }else{
                if(!password_verify($_POST["old_pass"].$this->config->app->encryption_token, $user->password)){
                    $answer[] = translate("tr_4c9d156d4de43dee4ad6806110595e98");
                }
            }

            if($this->validation->correctPassword($_POST['new_pass'])->status == false){
                $answer[] = translate("tr_44330856ee077a14ed4b3338de827987");
            }

        }else{

            if($this->validation->correctPassword($_POST['new_pass'])->status == false){
                $answer[] = translate("tr_44330856ee077a14ed4b3338de827987");
            }            

        }

        if(empty($answer)){

            $this->model->users->cacheKey(["id"=>$_POST['user_id']])->update(["password"=>password_hash($_POST['new_pass'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $_POST['user_id']);

            return json_answer(["status"=>true, "auth"=>true]);

        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);
        }

    }

    public function profileEdit(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $avatar = $_POST["avatar"] ? _json_decode(html_entity_decode($_POST["avatar"])) : [];
        $contacts = $_POST["contacts"] ? _json_decode(html_entity_decode($this->api->decryptAES($_POST["contacts"]))) : [];
        $notifications = $_POST["notifications"] ? _json_decode(html_entity_decode($_POST["notifications"])) : [];

        $_POST['phone'] = $_POST['phone'] ? $this->api->decryptAES($_POST['phone']) : '';
        $_POST['email'] = $_POST['email'] ? $this->api->decryptAES($_POST['email']) : '';

        $user = $this->model->users->find("id=?", [$_POST['user_id']]);

        $answer = [];

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_3547e6be2047611699aaad8432580eca");
        }

        if($_POST['user_status'] == "company"){
            if($this->validation->requiredField($_POST['organization_name'])->status == false){
                $answer[] = translate("tr_c59d7094b290e9a03b4f1107452cbbcc");
            }
        }

        $alias = slug($_POST['alias']);

        if($this->validation->requiredField($alias)->status == false){
            $answer[] = translate("tr_cd53fc5bbf6a1d1cdb38f16ed7d52f13");
        }else{
            $check = $this->model->users->find("alias=? and id!=?", [$alias, $_POST['user_id']]);
            if($check){
                $answer[] = translate("tr_a152a7e077f0555ecefd2d074e18592d");
            }            
        }

        if($this->validation->isEmail($_POST['email'])->status == true){
            $check = $this->model->users->find("email=? and id!=?", [$_POST['email'], $_POST['user_id']]);
            if(!$check){
                if($this->settings->email_confirmation_status){
                    if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$_POST["email"], $_POST['user_id']]) && $user->email != $_POST["email"]){
                        $answer[] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                    } 
                } 
            }else{
                $answer[] = translate("tr_8ba53c2654c841968bd295c36b0539f4");
            }         
        }

        if($this->validation->isPhone($_POST['phone'])->status == false){
            $answer[] = translate("tr_524283064f10cdddf715075cb1f5a2bb");
        }else{
            $check = $this->model->users->find("phone=? and id!=?", [$_POST['phone'], $_POST['user_id']]);
            if(!$check){
                if($this->settings->phone_confirmation_status){
                    if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$this->clean->phone($_POST["phone"]), $_POST['user_id']]) && $user->phone != $this->clean->phone($_POST["phone"])){
                        $answer[] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                    } 
                }
            }else{
                $answer[] = translate("tr_2bc796ae94354e49751455e509756e9d");
            }
        }

        if(empty($answer)){

            if($avatar){
                if($this->storage->path("temp")->name($avatar[0]["name"])->exist()){
                    $this->storage->name($user->avatar)->delete();
                    $avatarUpload = $this->storage->path($this->config->storage->temp)->name($avatar[0]["name"])->saveTo($this->config->storage->users->avatars)->copy();
                    $avatar = $avatarUpload->path;
                }else{
                    $avatar = $user->avatar;
                }
            }else{
                $avatar = $user->avatar;
            }

            if($notifications){
                if(is_array($notifications)){
                    $notifications = _json_encode($notifications);
                }else{
                    $notifications = null;
                }
            }

            if($_POST['notifications_method'] == "telegram"){
                $messenger_token_id = $user->messenger_token_id;
                $notifications_method = "telegram";
            }else{
                $messenger_token_id = null;
                $notifications_method = "email";
            }

            $this->model->users->cacheKey(["id"=>$_POST['user_id']])->update(["name"=>$_POST['name'],"surname"=>$_POST['surname'],"avatar"=>$avatar,"phone"=>$this->clean->phone($_POST['phone']),"email"=>$_POST['email'],"contacts"=>$this->component->profile->buildContacts($contacts), "notifications"=>$notifications ?: null, "user_status"=>$_POST['user_status'] == "user" ? 1 : 2, "alias"=>$alias, "organization_name"=>$_POST['organization_name'], "notifications_method"=>$notifications_method, "messenger_token_id"=>$messenger_token_id], $_POST['user_id']);

            return json_answer(["status"=>true, "auth"=>true]);

        }else{
            return json_answer(["status"=>false, "answer"=>implode("\n", $answer), "auth"=>true]);
        }

    }

    public function profileDelete(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->user->delete($_POST['user_id']);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function deleteScore(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($_POST['id']){

            $card = $this->model->users_payment_data->find("id=? and user_id=?", [$_POST['id'], $_POST['user_id']]);

            if($card){

                $this->model->users_payment_data->delete("id=? and user_id=?", [$_POST['id'], $_POST['user_id']]);

                $data = $this->model->users_payment_data->sort("id desc")->find("user_id=?", [$_POST['user_id']]);
               
                if($data){
                    $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$_POST['user_id'], $data->id]]);
                }

                if($card->card_id){
                    $this->component->transaction->paymentCardDelete($_POST['user_id'], $card->card_id);
                }

            }

        }

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function defaultScore(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($_POST['id']){
            $this->model->users_payment_data->update(["default_status"=>0], ["user_id=?", [$_POST['user_id']]]);
            $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$_POST['user_id'], (int)$_POST['id']]]);
        }

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function addScore(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($this->model->users_payment_data->count("user_id=?", [$_POST['user_id']]) >= 10){
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_7efb5c10f6ad317a2378e3d8edce624c")]);
        }

        if($this->validation->requiredField($_POST['score'])->status){

            $result = $this->component->profile->addPaymentScore($_POST['user_id'], $_POST['score']);

            return json_answer(["status"=>$result["status"], "answer"=>$result["answer"], "auth"=>true]);

        }else{
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_528a67adc943ea4fa07bf40c87be8294")]);
        }

    }

    public function addCard(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if(!$this->model->users_payment_data->find("user_id=? and type_score=?", [$_POST['user_id'], "add_card"])){
            $result = $this->component->transaction->paymentCardAdd($_POST['user_id']);
            return json_answer(["status"=>$result["status"], "answer"=>$result["answer"]?:null, "link"=>$result["link"]?:null, "auth"=>true]);
        }

        return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_876196cfa95230093e5c4f6e31459c4b")]);

    }

    public function fortuneAddBonus(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $bonuses = explode(",", $this->settings->api_app_fortune_bonus_items);
        $amount = round($this->api->decryptAES($_POST["amount"]), 2);

        if($this->settings->api_app_fortune_bonus_items && $bonuses){

            if(array_search($amount, $bonuses) || !$amount){

                $data = $this->model->users_bonuses_fortune->find("user_id=? and date(time_create)=date(NOW())", [$_POST['user_id']]);

                if(!$data){
                    $this->model->users_bonuses_fortune->insert(["user_id"=>$_POST['user_id'], "amount"=>$amount, "time_create"=>$this->datetime->getDate()]);
                    if($amount){
                        $this->component->transaction->manageUserBalance(["user_id"=>$_POST['user_id'], "amount"=>$amount], "+");
                    }
                }

            }

        }

        return json_answer(["status"=>true]);

    }

    public function getUsersBlacklist(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];

        $getUsers = $this->model->users_blacklist->sort("id desc")->getAll("from_user_id=?", [$_GET["user_id"]]);

        if($getUsers){
            foreach ($getUsers as $key => $value) {

                $user = $this->model->users->find("id=?", [$value["whom_user_id"]]);

                $result[] = [
                    "id"=>$value["id"],
                    "user_id"=>$value["whom_user_id"],
                    "avatar"=>$this->storage->name($user->avatar ? $user->avatar : null)->host(true)->get(),
                    "display_name"=>$user ? $this->user->name($user) : translate("tr_d4fa6456afc4e0742bcd2e86bbcfb32c"),
                ];

            }
        }

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function deleteUserBlacklist(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->users_blacklist->delete("id=? and from_user_id=?", [(int)$_POST['id'], (int)$_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function addDeliveryPoint(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($_POST['point_code']){
            $point = $this->model->delivery_points->find("code=?", [$_POST['point_code']]);

            if($point){

                $this->model->users_shipping_points->delete("user_id=? and delivery_id=?", [$_POST['user_id'], $point->delivery_id]);
                $this->model->users_shipping_points->insert(["user_id"=>$_POST['user_id'], "address"=>$point->address, "point_id"=>$point->id, "point_code"=>$point->code, "delivery_id"=>$point->delivery_id]);

            }
        }

        return json_answer(["status"=>true]);

    }

    public function getExtraStatistics(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $tariff = $this->component->service_tariffs->getOrderByUserId($_GET['user_id']);

        if(!$tariff->items->extra_statistics){
            return json_answer(null);
        }

        if(!$_GET['year']){
            $_GET['year'] = $this->datetime->format("Y")->getDate();
        }

        if(!$_GET['month']){
            $_GET['month'] = abs($this->datetime->format("m")->getDate());
        }

        $item_id = (int)$_GET['item_id'];
        $items = [];
        $result = [];
        $months_list = [];
        $actions = [];
        $item = [];
        $stat_data = [];

        if($_GET['search'] && _mb_strlen($_GET['search']) >= 2){
            $data = $this->model->ads_data->sort("id desc limit 50")->search($_GET['search'])->getAll("user_id=?", [$_GET['user_id']]); 
        }else{
            $data = $this->model->ads_data->getAll("user_id=? order by id desc limit 15", [$_GET['user_id']]); 
        }

        if($data){
            foreach ($data as $key => $value) {
                $value = $this->component->ads->getDataByValue($value);
                $items[] = [
                    "id"=>$value->id,
                    "title"=>$value->title,
                    "image"=>$value->media->images->first,
                    "price"=>$this->api->price(["ad"=>$value]),
                ];
            }
        }

        if($item_id){

            $ad = $this->component->ads->getAd($item_id, $_GET['user_id']);

            if($ad){

                $stat_data = $this->component->profile->getStatisticsChartMonth($item_id, $_GET['month'], $_GET['year'], $_GET['user_id'], "d");

                $item = [
                    "id"=>$ad->id,
                    "title"=>$ad->title,
                    "image"=>$ad->media->images->first,
                    "price"=>$this->api->price(["ad"=>$ad]),
                ];

            }

            $months_list[] = ["name"=>$this->datetime->getCurrentNameMonth($_GET['month']).', '.$_GET['year'], "month"=>$_GET['month'], "year"=>$_GET['year']];

            $x=0;
            while ($x++<12){

               if($_GET['month'] != $x){
                    $months_list[] = ["name"=>$this->datetime->getCurrentNameMonth($x).', '.$_GET['year'], "month"=>$x, "year"=>$_GET['year']];
               }

            }

            $getActions = $this->model->users_actions->sort("id desc")->filter(["date_start"=>$_GET['date_start'] ? date("Y-m-d", strtotime($_GET['date_start'])) : '', "date_end"=>$_GET['date_end'] ? date("Y-m-d", strtotime($_GET['date_end'])) : ''])->getAll("item_id=? and whom_user_id=?", [$item_id,$_GET['user_id']]);
            if($getActions){
                foreach ($getActions as $key => $value) {
                    $user = $this->model->users->cacheKey(["id"=>$value["from_user_id"]])->find('id=?', [$value["from_user_id"]]);
                    $actions[] = ["name"=>$this->component->profile->getActionCode($value["action_code"])->name, "user_name"=>$this->user->name($user), "user_avatar"=>$this->storage->name($user->avatar)->host(true)->get(), "time_create"=>$this->datetime->outDateTime($value["time_create"])];
                }
            }
         
        }

        return json_answer(["data"=>["items"=>$items ?: null, "actions"=>$actions ?: null, "months_list"=>$months_list ?: null, "stat_data"=>$stat_data ?: null, "item"=>$item ?: null], "auth"=>true]);

    }

}