<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ShopController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getData(){

        $result = [];
        $pages = [];
        $owner = false;
        $banners = [];
        $reviews = [];
        $reviewsMedia = [];
        $messengers = [];
        $contactsData = [];

        $shop = $this->model->shops->find("id=?", [intval($_GET['id'])]);
        $user = $this->model->users->find("id=?", [(int)$shop->user_id]);

        if(!$shop || !$user || !$this->settings->shops_status){
            return json_answer(["exist"=>false]);
        }

        $contacts = $user->contacts ? _json_decode(decrypt($user->contacts)) : [];
        $tariff = $this->component->service_tariffs->getOrderByUserId($shop->user_id);
        $countAds = $this->model->ads_data->count("user_id = ? and status = ?", [$shop->user_id,1]);
        $countSubscribers = $this->model->users_subscriptions->count("whom_user_id = ?", [$shop->user_id]);

        if(intval($_GET['user_id'])){
            $getSubscribed = $this->model->users_subscriptions->count("user_id = ? and whom_user_id = ?", [intval($_GET['user_id']),$shop->user_id]);
        }

        if(!$tariff->items->shop){
            return json_answer(["exist"=>false]);
        }

        if($this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            if($_GET['user_id'] == $shop->user_id){
                $owner = true;
            }
        }

        $getPages = $this->model->shops_pages->getAll("shop_id=?", [$shop->id]);
        if($getPages){
            foreach ($getPages as $key => $value) {
                $pages[] = ["id"=>$value["id"], "name"=>$value["name"], "text"=>html_entity_decode(strip_tags(urldecode($value["text"])))];
            }
        }

        $getBanners = $this->model->shops_banners->getAll("shop_id=?", [$shop->id]);
        if($getBanners){
            foreach ($getBanners as $key => $value) {
                $banners[] = ["id"=>$value["id"], "name"=>basename($value["image"]), "link"=>$this->storage->name($value["image"])->host(true)->get(), "type"=>"image"];
            }
        }

        if($contacts["whatsapp"]){
            $messengers[] = ["name"=>"WhatsApp", "image"=>$this->storage->name("social/wa.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("whatsapp://send?phone=".$this->api->encryptAES($contacts["whatsapp"]))];
        }

        if($contacts["telegram"]){
            $messengers[] = ["name"=>"Telegram", "image"=>$this->storage->name("social/tg.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("tg://resolve?domain=".$this->api->encryptAES($contacts["telegram"]))];
        }

        if($contacts["max"]){
            $messengers[] = ["name"=>"Max", "image"=>$this->storage->name("social/max.png")->path('images')->host(true)->get(), "contact"=>$this->api->encryptAES("max://".$this->api->encryptAES($contacts["max"]))];
        }

        if($shop->status == "awaiting_verification"){
            $status_note = translate("tr_13068c40c12a556c1ed7cd182ac6ab87");
        }elseif($shop->status == "blocked"){
            $status_note = translate("tr_06d1f50f12d3f3426428c3de06aac118");
        }elseif($shop->status == "rejected"){
            $status_note = translate("tr_22c9a6fed5c73377cc7b17aed5d649df");
        }

        $getReviews = $this->model->reviews->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$shop->user_id, 1, 0]);

        if($getReviews){
            foreach ($getReviews as $key => $value) {
                $reviews[] = $this->api->reviewData($value);
                if($value['media']){
                    $r_media = _json_decode($value['media']);
                    foreach ($r_media as $media_item) {
                        $ad = $this->component->ads->getAd($value["item_id"]);
                        $reviewsMedia[] = ["id"=>$value["id"], "link"=>$this->storage->name($media_item)->host(true)->get(), "text"=>html_entity_decode($value["text"]), "type"=>"image", "ad_id"=>$ad->id, "image"=>$ad->media->images->first, "title"=>$ad->title, "price"=>$this->system->amount($ad->price), "rating"=>$value["rating"]];
                    }
                }
            }
        }

        if($this->settings->phone_add_plus_status){
            $contactsData = ["email"=>$user->email ? $this->api->encryptAES($user->email) : null, "phone"=>$user->phone ? '+'.trim($this->api->encryptAES($user->phone), "+") : null, "messengers"=>$messengers ?: null];
        }else{
            $contactsData = ["email"=>$user->email ? $this->api->encryptAES($user->email) : null, "phone"=>$user->phone ? $this->api->encryptAES($user->phone) : null, "messengers"=>$messengers ?: null];
        }

        $result = [
            "chat_token"=>intval($_GET['user_id']) ? $this->component->chat->buildToken(["from_user_id"=>intval($_GET['user_id']), "whom_user_id"=>$shop->user_id]) : null,
            "status"=>$shop->status,
            "status_note" => $status_note ?: '',
            "active_status"=>$shop->status == "published" ? true : false,
            "owner"=>$owner,
            "id"=>$shop->id,
            "contacts" => $contactsData,
            "title"=>html_entity_decode($shop->title),
            "text"=>html_entity_decode($shop->text),
            "logo"=>$this->storage->name($shop->image)->host(true)->get(),
            "link"=>$this->component->shop->linkToShopCard($value["alias"]),
            "pages"=>$pages ?: null,
            "banners"=>$banners ?: [],
            "count_ads" => $countAds,
            "subscribers_count" => $countSubscribers,
            "subscribed" => $getSubscribed ? true : false,
            "user"=>[
                "id"=>$user->id,
                "rating" => $user->total_rating,
                "verification_status" => $user->verification_status ? true : false,
                "reviews_label" => $user->total_reviews . " " . endingWord($user->total_reviews, "отзыв", "отзыва", "отзывов"),
                "mode_online" => $this->api->userActivityStatus($user->time_last_activity),
                "show_rating"=>$user->total_rating ? true : false,
            ],
            "reviews" => $reviews ?: null,
            "reviews_media" => $reviewsMedia ?: null,
            "reviews_preview_index" => $reviews ? count($reviews)-1 : null,
        ];

        return json_answer(["data"=>$result, "exist"=>true]);

    }

    public function create(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $answer = [];
        $cat_id = (int)$_POST['cat_id'];

        $_POST['logo'] = $_POST['logo'] ? _json_decode(html_entity_decode($_POST['logo'])) : [];

        $getShop = $this->model->shops->find("user_id=?", [$_POST['user_id']]);

        if($getShop){
            return json_answer(["status"=>false, "answer"=>"У вас уже есть магазин", "auth"=>true]);
        }

        $service_tariff = $this->component->service_tariffs->getOrderByUserId($_POST['user_id']);

        if(!$this->component->profile->checkVerificationPermissions($_POST['user_id'], "open_shop")){
            return json_answer(["verification"=>false, "auth"=>true]);
        }

        if(!$service_tariff->items->shop){
            $answer[] = translate("tr_f0a91f869a1404b7a79379f88f59d129");
        }

        if($this->validation->requiredFieldArray($_POST['logo'])->status == false){
            $answer[] = translate("tr_41032363a6eaff203414f90af4c495fd");
        }

        if($this->validation->requiredField($_POST['title'])->status == false){
            $answer[] = translate("tr_a7f8a505c03860819c69c3f9c13ac37f");
        }

        if($this->validation->requiredField($cat_id)->status == true){
            if(!$this->component->ads_categories->categories[$cat_id]){
                $answer[] = translate("tr_efdece7784c7deea23fa2e2df010d28e");
            }
        }

        $alias = slug($_POST['alias']);

        if($service_tariff->items->unique_shop_address){
            if($this->validation->requiredField($alias)->status == false){
                $answer[] = translate("tr_3e5ebe0c0dc4ba396186e7c90b1c18a3");
            }else{
                $check = $this->model->shops->find("alias=?", [$alias]);
                if($check){
                    $answer[] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
                }else{
                    $unique_shop_address = $alias;
                }
            }
        }else{
            $unique_shop_address = generateCode(30);
        }

        if(!$answer){

            if($_POST['logo']){
                $_POST["logo"] = $this->storage->uploadAttachFiles([$_POST['logo'][0]['name']], $this->config->storage->users->attached);
            }

            $shop_id = $this->model->shops->insert(["user_id"=>$_POST['user_id'], "title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>$cat_id, "image"=>$_POST['logo'] ? $_POST['logo'][0] : null, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published", "time_create"=>$this->datetime->getDate()]);

            $this->event->createShop(["user_id"=>$_POST['user_id'], "shop_id"=>$shop_id]);

            return json_answer(["status"=>true, "id"=>$shop_id, "auth"=>true, "verification"=>true]);

        }else{

            return json_answer(["status"=>false, "answer"=>implode("\n", $answer), "auth"=>true, "verification"=>true]);

        }

    }

    public function load(){

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $pages = [];

        $shop = $this->model->shops->find("id=? and user_id=?", [$_GET['id'],$_GET['user_id']]);

        if(!$shop){
            return json_answer(null);
        }

        $getPages = $this->model->shops_pages->getAll("shop_id=?", [$shop->id]);
        if($getPages){
            foreach ($getPages as $key => $value) {
                $pages[] = ["id"=>$value["id"], "name"=>$value["name"], "text"=>html_entity_decode(strip_tags(urldecode($value["text"])))];
            }
        }

        $result = [
            "title"=>html_entity_decode($shop->title),
            "text"=>html_entity_decode($shop->text),
            "cat_id"=>$shop->category_id ?: null,
            "logo"=>$this->storage->name($shop->image)->host(true)->get(),
            "pages"=>$pages ?: null,
            "alias"=>$shop->alias,
        ];

        return json_answer(["data"=>$result, "auth"=>true]);

    }

    public function edit(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $answer = [];
        $cat_id = (int)$_POST['cat_id'];

        $_POST['logo'] = $_POST['logo'] ? _json_decode(html_entity_decode($_POST['logo'])) : [];

        $service_tariff = $this->component->service_tariffs->getOrderByUserId($_POST['user_id']);

        $shop = $this->model->shops->find("user_id=? and id=?", [$_POST['user_id'], (int)$_POST['id']]);

        if(!$shop){
            return json_answer(null);
        }

        if($this->validation->requiredField($_POST['title'])->status == false){
            $answer[] = translate("tr_a7f8a505c03860819c69c3f9c13ac37f");
        }

        if($this->validation->requiredField($cat_id)->status == true){
            if(!$this->component->ads_categories->categories[$cat_id]){
                $answer[] = translate("tr_efdece7784c7deea23fa2e2df010d28e");
            }
        }

        $alias = slug($_POST['alias']);

        if($service_tariff->items->unique_shop_address){
            if($this->validation->requiredField($alias)->status == false){
                $answer[] = translate("tr_3e5ebe0c0dc4ba396186e7c90b1c18a3");
            }else{
                $check = $this->model->shops->find("alias=? and id!=?", [$alias, $shop->id]);
                if($check){
                    $answer[] = translate("tr_4620efb761967524f1d5a5d395d4e3d6");
                }else{
                    $unique_shop_address = $alias;
                }
            }
        }else{
            $unique_shop_address = $shop->alias;
        }

        if(!$answer){

            if($_POST['logo']){
                $_POST["logo"] = $this->storage->uploadAttachFiles([$_POST['logo'][0]['name']], $this->config->storage->users->attached);
            }

            $this->model->shops->update(["title"=>$_POST['title'], "text"=>$_POST['text'], "category_id"=>$cat_id, "image"=>$_POST['logo'] ? $_POST['logo'][0] : $shop->image, "alias"=>$unique_shop_address, "status"=>$this->settings->shop_moderation_status ? "awaiting_verification" : "published"], $shop->id);

            $this->event->editShop(["user_id"=>$_POST['user_id'], "shop_id"=>$shop->id, "action"=>"edit_shop"]);

            return json_answer(["status"=>true, "auth"=>true]);

        }else{

            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);

        }

    }

    public function addPage(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $service_tariff = $this->component->service_tariffs->getOrderByUserId($_POST['user_id']);

        if(!$service_tariff->items->shop_page){
            $answer[] = translate("tr_96b7abe9f0156a5c72f0f34fb6e1f56d");
        }

        $shop = $this->model->shops->find("user_id=? and id=?", [$_POST['user_id'], $_POST['id']]);

        if(!$shop){
            return json_answer(null);
        }

        if($this->model->shops_pages->count("shop_id=?", [$shop->id]) >= $this->settings->shop_max_pages){
            return json_answer(["status"=>false, "auth"=>true, "answer"=>translate("tr_8104c6c3a3e7b62a653218094b3926ee")]);
        }

        $alias = slug($_POST['name']);

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_4cacc68f9225daa078f4a2307a02a33d");
        }else{
            $check = $this->model->shops_pages->find("alias=? and shop_id=?", [$alias, $shop->id]);
            if($check){
                $answer[] = translate("tr_0aa88c0caa1820b71895d6f44422da78");
            }
        }

        if($this->validation->requiredField($_POST['text'])->status == false){
            $answer[] = translate("tr_4d605e2321ebde65d8cf66a84c9b415a");
        }

        if(!$answer){

            $this->model->shops_pages->insert(["user_id"=>$_POST['user_id'], "name"=>$_POST['name'], "text"=>$_POST['text'], "shop_id"=>$shop->id, "alias"=>$alias]);

            $this->event->editShop(["user_id"=>$_POST['user_id'], "shop_id"=>$shop->id, "action"=>"add_page_shop"]);

            return json_answer(["status"=>true, "auth"=>true]);

        }else{

            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);

        }

    }

    public function editPage(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $page = $this->model->shops_pages->find("user_id=? and id=?", [$_POST['user_id'], (int)$_POST['page_id']]);

        if(!$page){
            return json_answer(null);
        }

        $alias = slug($_POST['name']);

        if($this->validation->requiredField($_POST['name'])->status == false){
            $answer[] = translate("tr_4cacc68f9225daa078f4a2307a02a33d");
        }else{
            $check = $this->model->shops_pages->find("alias=? and shop_id=? and id!=?", [$alias, $page->shop_id, (int)$_POST['page_id']]);
            if($check){
                $answer[] = translate("tr_0aa88c0caa1820b71895d6f44422da78");
            }
        }

        if($this->validation->requiredField($_POST['text'])->status == false){
            $answer[] = translate("tr_4d605e2321ebde65d8cf66a84c9b415a");
        }

        if(!$answer){

            $this->model->shops_pages->update(["name"=>$_POST['name'], "text"=>$_POST['text']], (int)$_POST['page_id']);

            $this->event->editShop(["user_id"=>$_POST['user_id'], "shop_id"=>$page->shop_id, "action"=>"edit_page_text_shop", "page_name"=>$page->name]);

            return json_answer(["status"=>true, "auth"=>true]);

        }else{

            return json_answer(["status"=>false, "auth"=>true, "answer"=>implode("\n", $answer)]);

        }

    }

    public function deletePage(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $page = $this->model->shops_pages->find("user_id=? and id=?", [$_POST['user_id'], (int)$_POST['page_id']]);

        if(!$page){
            return json_answer(null);
        }

        $this->model->shops_pages->delete("id=? and user_id=?", [(int)$_POST['page_id'], $_POST['user_id']]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function deleteShop(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->component->shop->delete($_POST["id"], $_POST['user_id']);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function deleteBanner(){

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $banner = $this->model->shops_banners->find("user_id=? and id=?", [$_POST['user_id'], (int)$_POST['id']]);

        if(!$banner){
            return json_answer(null);
        }

        $this->model->shops_banners->delete("id=?", [$banner->id]);
        $this->storage->clearAttachFiles([$banner->image]);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function searchItems(){

        $result = [];
        $words = [];

        $shop = $this->model->shops->find("id=?", [(int)$_GET['shop_id']]);

        if(!$shop){
            return json_answer(null);
        }

        $real_query = $_GET["query"];
        $data = $this->component->search->splitKeywords($_GET["query"]);

        $query = $data["query"];

        $keywords["query"][] = 'name LIKE ?';
        $keywords["params"][] = '%'.$query.'%';

        if($data["split"]){

            foreach ($data["split"] as $key => $value) {
                if(mb_strlen(trim($value), "UTF-8") > 1){
                    $words[] = trim($value);
                }
            }

            if(count($words) == 1){

                $keywords["query"][] = "(name LIKE ? or tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[0].'%';

            }elseif(count($words) == 2){
              
                $keywords["query"][] = "(name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';

            }elseif(count($words) == 3){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';

            }elseif(count($words) == 4){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';

            }elseif(count($words) == 5){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';

            }elseif(count($words) == 6){
                
                $keywords["query"][] = "(name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ? and name LIKE ?) or (tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ? and tags LIKE ?)";
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[5].'%';
                $keywords["params"][] = '%'.$words[0].'%';
                $keywords["params"][] = '%'.$words[1].'%';
                $keywords["params"][] = '%'.$words[2].'%';
                $keywords["params"][] = '%'.$words[3].'%';
                $keywords["params"][] = '%'.$words[4].'%';
                $keywords["params"][] = '%'.$words[5].'%';

            }

        }

        if($this->settings->search_allowed_text){
            $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "text", "article_number"]);
        }else{
            $itemQuery = $this->component->search->buildKeywordsFields($data["split"], ["search_tags", "title", "article_number"]);
        }

        $itemQuery["query"] = "((".$itemQuery["query"].") or title LIKE ?) and status=? and user_id=? limit 50";
        $itemQuery["params"][] = "%".$real_query."%";
        $itemQuery["params"][] = 1;
        $itemQuery["params"][] = $shop->user_id;

        $searchItems = $this->model->ads_data->getAll($itemQuery["query"], $itemQuery["params"]);

        if($searchItems){
            foreach ($searchItems as $key => $value) {
                $value = $this->component->ads->getDataByValue($value);
                $result[] = ["title"=>$value->title, "image"=>$value->media->images->first, "price"=>$this->api->price(["ad"=>$value]), "subtitle"=>translate("tr_a8017171f9cfb1e5367ef6d7ae6a8e9d"), "id"=>$value->id];
            } 
        }        

        return json_answer(["status"=>true, "data"=>$result]);

    }

}