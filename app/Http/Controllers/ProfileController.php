<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class ProfileController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addComplaint(){

    if($this->validation->requiredField($_POST['text'])->status == false){
        return json_answer(["status"=>false, "answer"=>translate("tr_c5f9d5595eb159c22ec1fed1bf239aa5")]);
    }else{

        $data = $this->model->users->find("id=?", [$_POST["id"]]);

        if($data){

            if(!$this->model->complaints->find("from_user_id=? and whom_user_id=? and item_id=? and status=?", [$this->user->data->id,$_POST["id"],0,0])){
                $this->model->complaints->insert(["from_user_id"=>$this->user->data->id,"text"=>$_POST["text"],"item_id"=>0,"whom_user_id"=>$_POST["id"],"time_create"=>$this->datetime->getDate()]);
                $this->event->addComplaintUser(["from_user_id"=>$this->user->data->id, "whom_user_id"=>$_POST["id"], "text"=>$_POST["text"]]);
            }

        }

    } 

    return json_answer(["status"=>true, "answer"=>translate("tr_9ce23934d783d857c38fc685eb0b5049")]);
    
}

public function ads()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getAllAdsUser($this->user->data->id, $_GET['status']);

    return $this->view->render('profile/ads', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_083ab3d9a9221cf6a1641c2c7c5f0d3c")]]);
}

public function autorenewal()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getRenewalAdsUser($this->user->data->id);
    
    return $this->view->render('profile/autorenewal', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_f139acad6b9e9ae951fc74f9df710e96")]]);
}

public function blacklistAdd()
{   

    $result = $this->component->profile->addToBlacklist($this->user->data->id, $_POST['id'], $_POST['channel_id']);

    if($result){
        return json_answer(["answer"=>translate("tr_dc322d08f2015f6b63d17cb7b8b15d3e"), "label"=>translate("tr_e3d48147853bb99996169256b5eb7cb9")]);
    }else{
        return json_answer(["answer"=>translate("tr_a58a5c103be003b8a1a58e101a0e45ca"), "label"=>translate("tr_35903deefce1704c3623df8a08d9880f")]);
    }
    
}

public function chat()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->channels = $this->component->chat->getChannels($this->user->data->id);
    $data->dialogues = $this->component->chat->getDialogues($this->user->data->id);

    $data->dialogues = $this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogues.tpl');

    return $this->view->render('profile/chat', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c52b4c5cbc879d56c633f568acfbf205")]]);
}

public function deliveryAddPoint()
{

    if(intval($_POST["id"]) && $_POST["point_code"]){

        $point = $this->model->delivery_points->find("id=? and code=? and send=?", [intval($_POST["id"]),$_POST["point_code"], 1]);

        if($point){

            $this->model->users_shipping_points->delete("user_id=? and delivery_id=?", [$this->user->data->id, $point->delivery_id]);
            $this->model->users_shipping_points->insert(["user_id"=>$this->user->data->id, "address"=>$point->address, "point_id"=>intval($_POST["id"]), "point_code"=>$_POST["point_code"], "delivery_id"=>$point->delivery_id]);

        }

    }

    return json_answer(["status"=>true]);

}

public function deliveryStatus()
{

    if($_POST["status"] == "true"){
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["delivery_status"=>1], $this->user->data->id);
        $this->model->ads_data->update(["delivery_status"=>1], ["user_id=? and delivery_status=?", [$this->user->data->id,2]]);
    }else{
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["delivery_status"=>0], $this->user->data->id);
        $this->model->ads_data->update(["delivery_status"=>2], ["user_id=? and delivery_status=?", [$this->user->data->id,1]]);
    }

    return json_answer(["status"=>true]);

}

public function editPassword()
{   

    $answer = [];

    if($this->user->data->password){

        if($this->validation->requiredField($_POST['old_pass'])->status == false){
            $answer['old_pass'] = $this->validation->error;
        }else{
            if(!password_verify($_POST["old_pass"].$this->config->app->encryption_token, $this->user->data->password)){
                $answer['old_pass'] = translate("tr_e76187c75f69608ef386fc23db8eec34");
            }
        }

        if($this->validation->correctPassword($_POST['new_pass'])->status == false){
            $answer['new_pass'] = $this->validation->error;
        }

    }else{

        if($this->validation->correctPassword($_POST['new_pass'])->status == false){
            $answer['new_pass'] = $this->validation->error;
        }            

    }

    if(empty($answer)){

        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["password"=>password_hash($_POST['new_pass'].$this->config->app->encryption_token, PASSWORD_DEFAULT)], $this->user->data->id);

        return json_answer(["status"=>true, "answer"=>translate("tr_162eb0f2ead5d9cbb88ded41a2ba7644")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function favoriteAdd()
{   

    $get = $this->model->users_favorites->find("ad_id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($get){

        $this->model->users_favorites->delete("id=?", [$get->id]);

        return json_answer(["status"=>false]);

    }else{

        $ad = $this->component->ads->getAd($_POST['id']);

        if($ad && !$ad->delete){

            $params = ["user_id"=>$this->user->data->id, "ad_id"=>$_POST['id'], "time_create"=>$this->datetime->getDate()];

            $this->model->users_favorites->insert($params);

            $this->event->addToFavorite(["user_id"=>$this->user->data->id, "ad_id"=>$_POST['id']]);

        }

        return json_answer(["status"=>true]);

    }

}

public function favorites()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'ads')){
        $data->favorites = $this->component->profile->getFavorites($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'searches')){
        $data->favorites = $this->component->profile->getSearches($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'subscriptions')){
        $data->favorites = $this->component->profile->getSubscriptions($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'viewed')){
        $data->favorites = $this->component->profile->getViewed($this->user->data->id);
    }else{
        $data->favorites = $this->component->profile->getFavorites($this->user->data->id);
    }
    
    return $this->view->render('profile/favorites', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_2fc413929104c1a09ae0a66c48ce0902")]]);
}

public function fixTransitionReferral($alias)
{

    $this->component->profile->fixTransitionReferral($alias);

    $this->router->goToRoute("home");

}

public function loadStatisticsChartMonth()
{

    return $this->component->profile->getStatisticsChartMonth($_POST['item_id'], $_POST['month'], $_POST['year'], $this->user->data->id);

}

public function orders()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'buy')){
        $data->orders = $this->component->profile->getFromUserOrders($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'sell')){
        $data->orders = $this->component->profile->getWhomUserOrders($this->user->data->id);
    }else{
        $data->orders = $this->component->profile->getFromUserOrders($this->user->data->id);
    }
    
    return $this->view->render('profile/orders', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_0905527faec7de502c0e62ce318af892")]]);
}

public function paymentCardAdd()
{

    if(!$this->model->users_payment_data->find("user_id=? and type_score=?", [$this->user->data->id, "add_card"])){
        $result = $this->component->transaction->paymentCardAdd($this->user->data->id);
        return json_answer($result);
    }

    return json_answer(["status"=>false, "answer"=>translate("tr_876196cfa95230093e5c4f6e31459c4b")]);

}

public function paymentScoreAdd()
{

    $answer = [];

    if($this->model->users_payment_data->count("user_id=?", [$this->user->data->id]) >= 10){
        return json_answer(["status"=>false, "answer"=>translate("tr_7efb5c10f6ad317a2378e3d8edce624c")]);
    }

    if($this->validation->requiredField($_POST['score'])->status){

        $result = $this->component->profile->addPaymentScore($this->user->data->id, $_POST['score']);

        return json_answer($result);

    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_528a67adc943ea4fa07bf40c87be8294")]);
    }

}

public function paymentScoreDefault()
{

    $this->model->users_payment_data->update(["default_status"=>0], ["user_id=?", [$this->user->data->id]]);

    $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$this->user->data->id, $_POST['id']]]);

    return json_answer(["status"=>true]);

}

public function paymentScoreDelete()
{

    $card = $this->model->users_payment_data->find("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($card){

        $this->model->users_payment_data->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

        $data = $this->model->users_payment_data->sort("id desc")->find("user_id=?", [$this->user->data->id]);
       
        if($data){
            $this->model->users_payment_data->update(["default_status"=>1], ["user_id=? and id=?", [$this->user->data->id, $data->id]]);
        }

        if($card->card_id){
            $this->component->transaction->paymentCardDelete($this->user->data->id, $card->card_id);
        }

    }

    return json_answer(["status"=>true]);

}

public function profile()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->ads = $this->component->profile->getHomeAdsUser($this->user->data->id);
    $data->favorites = $this->component->profile->getHomeFavoritesAdsUser($this->user->data->id);
    $data->orders = $this->component->profile->getHomeOrdersUser($this->user->data->id);
    $data->reviews = $this->component->profile->getHomeReviews($this->user->data->id);

    return $this->view->render('profile', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a46c372347e02010f5ef45fe441e4349")]]);
}

public function profileDelete()
{   

    $this->user->delete($this->user->data->id);
    return json_answer(["status"=>true]);

}

public function referral()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->referral_program_status || !$this->settings->profile_wallet_status){
        abort(404);
    }

    if(compareValues($_GET['tab'], 'rewards')){
        $data->referrals = $this->component->profile->getAllAwardsReferrals($this->user->data->id);
    }else{
        $data->referrals = $this->component->profile->getAllUsersReferrals($this->user->data->id);
    }

    return $this->view->render('profile/referral', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_af290a256ca664b10c4fd61c9534c635")]]);
}

public function renewalDelete()
{   

    $this->model->ads_data->cacheKey(["id"=>$_POST['id']])->update(["auto_renewal_status"=>0], ["id=? and user_id=?", [$_POST['id'], $this->user->data->id]]);
    return json_answer(["status"=>true]);
    
}

public function reviews()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'my_reviews')){
        $data->reviews = $this->component->profile->getMyReviews($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'added')){
        $data->reviews = $this->component->profile->getAddedReviews($this->user->data->id);
    }else{
        $data->reviews = $this->component->profile->getMyReviews($this->user->data->id);
    }
    
    return $this->view->render('profile/reviews', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_1c3fea01a64e56bd70c233491dd537aa")]]);
}

public function searchDelete()
{   

    $this->model->users_searches->delete("id=? and user_id=?", [$_POST['id'], $this->user->data->id]);
    return json_answer(["status"=>true]);
    
}

public function searchUserItemsInStatistics()
{   

    $result = '';

    if(_mb_strlen($_POST['query']) < 2){
        return json_answer(["status"=>false]);
    }

    $getAds = $this->model->ads_data->sort("id desc")->search($_POST['query'])->getAll("user_id=? and status IN(1,3,7)", [$this->user->data->id]);

    if($getAds){
        foreach ($getAds as $key => $value) {
            $result .= '
                  <a class="user-item-container" href="'.$this->router->getRoute('profile-statistics').'?item_id='.$value["id"].'" >
                      <div class="user-item-container-box1" >
                         <div class="user-item-container-image" >
                            <img src="'.$this->component->ads->getMedia($value["media"])->images->first.'" class="image-autofocus" >
                         </div>
                      </div>
                      <div class="user-item-container-box2" >
                         <span>'.$value["title"].'</span>
                         <span>'.$this->component->ads->outPriceAndCurrency($value).'</span>
                      </div>
                  </a>
            ';
        }
        return json_answer(["status"=>true, "answer"=>$result]);
    }

    return json_answer(["status"=>false, "answer"=>translate("tr_8767f9ec282489d3e8e29021d0967187")]);
       
}

public function settings()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];
    
    return $this->view->render('profile/settings', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c919d65bd95698af8f15fa8133bf490d")]]);
}

public function settingsEdit()
{   

    $answer = [];
    $notifications = null;

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['user_status'] == 2){
        if($this->validation->requiredField($_POST['organization_name'])->status == false){
            $answer['organization_name'] = $this->validation->error;
        }
    }

    $alias = slug($_POST['alias']);

    if($this->validation->requiredField($alias)->status == false){
        $answer['alias'] = $this->validation->error;
    }else{
        $check = $this->model->users->find("alias=? and id!=?", [$alias, $this->user->data->id]);
        if($check){
            $answer['alias'] = translate("tr_da89ae2fe97056aa863f06fe02c8e928");
        }            
    }

    if($this->validation->isEmail($_POST['email'])->status == false){
        $answer['email'] = $this->validation->error;
    }else{
        $check = $this->model->users->find("email=? and id!=?", [$_POST['email'], $this->user->data->id]);
        if(!$check){
            if($this->settings->email_confirmation_status){
                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$_POST["email"], $this->user->data->id]) && $this->user->data->email != $_POST["email"]){
                    $answer['email'] = translate("tr_1a9d5cffc42fd0c3e8ba8f9773687ecb");
                } 
            } 
        }else{
            $answer['email'] = translate("tr_cf1f1bf7bef7a6c5b46d3fb9fb7fc356");
        }         
    }

    if($this->validation->isPhone($_POST['phone'])->status == false){
        $answer['phone'] = $this->validation->error;
    }else{
        $check = $this->model->users->find("phone=? and id!=?", [$_POST['phone'], $this->user->data->id]);
        if(!$check){
            if($this->settings->phone_confirmation_status){
                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$this->clean->phone($_POST["phone"]), $this->user->data->id]) && $this->user->data->phone != $this->clean->phone($_POST["phone"])){
                    $answer['phone'] = translate("tr_92899cea85e05d5f506efb774dfd87a3");
                } 
            }
        }else{
            $answer['phone'] = translate("tr_2bc2b50b4f571139f35fe4dcd17ce38d");
        }
    }

    if(empty($answer)){

        if($_POST['notifications']){
            if(is_array($_POST['notifications'])){
                $notifications = _json_encode($_POST['notifications']);
            }
        }

        if($_POST['notifications_method'] == "telegram"){
            $messenger_token_id = $this->user->data->messenger_token_id;
            $notifications_method = "telegram";
        }else{
            $messenger_token_id = null;
            $notifications_method = "email";
        }

        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["name"=>$_POST['name'],"surname"=>$_POST['surname'],"phone"=>$this->clean->phone($_POST['phone']),"email"=>$_POST['email'],"contacts"=>$this->component->profile->buildContacts($_POST['contacts']), "notifications"=>$notifications, "user_status"=>(int)$_POST['user_status'] ?: 1, "alias"=>$alias, "organization_name"=>$_POST['organization_name'], "notifications_method"=>$notifications_method, "messenger_token_id"=>$messenger_token_id], $this->user->data->id);

        return json_answer(["status"=>true, "answer"=>translate("tr_481f846c0f4fa251363447107c663265")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}

public function shop()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/shop.js\" type=\"module\" ></script>"]);

    $shop = $this->component->shop->getShopByUserId($this->user->data->id);

    if($shop){
        if($this->user->data->service_tariff->items->shop){
            $this->router->goToUrl($this->component->shop->linkToShopCard($shop->alias));
        }
    }

    return $this->view->render('profile/shop', ["seo"=>(object)["meta_title"=>translate("tr_838c33a96c1a3d15354de92dae7a0f08")]]);
}

public function statistics()
{   

    $this->view->visible_header = false;

    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/apexcharts/apexcharts.css\" />"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/apexcharts/apexcharts.min.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];
    
    return $this->view->render('profile/statistics', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a62b9e5890d76fe02b0c809915136afd")]]);
}

public function subscribeUser()
{   

    $get = $this->model->users_subscriptions->find("whom_user_id=? and user_id=?", [$_POST['id'], $this->user->data->id]);

    if($get){

        $this->model->users_subscriptions->delete("id=?", [$get->id]);

        return json_answer(["status"=>false, "answer"=>translate("tr_638599971fc418274ea865e6fd9f758a"), "label"=>translate("tr_3b1913989f1a538261b8abf5ffc88d4b")]);

    }else{

        $user = $this->model->users->findById($_POST['id']);

        if($user && !$user->delete){
            $params = ["user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['id'], "time_create"=>$this->datetime->getDate()];

            $this->model->users_subscriptions->insert($params);

            $this->event->subscribeUser(["from_user_id"=>$this->user->data->id, "whom_user_id"=>$_POST['id']]);

            return json_answer(["status"=>true, "answer"=>translate("tr_38b7895643fca9471f5710bca2270601"), "label"=>translate("tr_d2023e4c921d1cc5865f230480442d3c")]);                
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_e9aacbf73724cdc9294d4eed84b700a3")]);
        }

    }
    
}

public function tariffs()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    return $this->view->render('profile/tariffs', ["seo"=>(object)["meta_title"=>translate("tr_a49106cadab8ae1ff6a37e7ccea9c665")]]);
}

public function uploadAvatar()
{   

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('user-avatar')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $this->storage->name($this->user->data->avatar)->delete();
        $this->model->users->cacheKey(["id"=>$this->user->data->id])->update(["avatar"=>clearPath($resultUpload["path"])], $this->user->data->id);

    }

    return json_answer(["status"=>true]);
       
}

public function user($alias)
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
   
    $data = (object)[];

    $data->user = $this->model->users->findByAlias($alias, true);

    if($data->user && !$data->user->delete){

        if($data->user->id == $this->user->data->id){ 
            $this->router->goToRoute("profile");
        }else{

            $shop = $this->component->shop->getShopByUserId($data->user->id);

            if($shop){
                if($shop->status == "published"){
                    $this->router->goToUrl($this->component->shop->linkToShopCard($shop->alias));
                }
            }

        }

    }else{
        abort(404);
    }

    $data->ads = $this->component->profile->getHomeAdsUserOnlyActive($data->user->id);
    $data->reviews = $this->component->profile->getMyReviews($data->user->id);

    $seo = $this->component->seo->content($data);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    return $this->view->render('user-card', ["data"=>(object)$data, "seo"=>$seo]);
}

public function userAds($alias)
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);
   
    $data = (object)[];

    $data->user = $this->model->users->findByAlias($alias, true);

    if($data->user && !$data->user->delete){
        if($data->user->id == $this->user->data->id){
            $this->router->goToRoute("profile");
        }
    }else{
        abort(404);
    }

    $data->ads = $this->component->profile->getAllAdsUserInCard($data->user->id, $_GET['status']);

    $this->view->setParamsComponent(['data'=>(object)$data]);

    $seo = $this->component->seo->content($data);

    return $this->view->render('user-card-ads', ["data"=>(object)$data, "seo"=>$seo]);
}

public function verification()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->verification_users_status){
        abort(404);
    }

    if(!$this->session->get("user-verification-code")){
        $this->session->set("user-verification-code", mt_rand(1000000,9000000));
    }

    $data->uniq_code = $this->session->get("user-verification-code");
    $data->verification = $this->model->users_verifications->find("user_id=?", [$this->user->data->id]) ?: null;

    return $this->view->render('profile/verification', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c7cadea1c393b4b40ed898d48f10c1b0")]]);
}

public function verificationSend()
{   

    $answer = [];

    if(!$this->user->data->phone){
        $answer[] = translate("tr_d817ba992bb0e66e0cc7d881cc20b3d7");
    }

    if(!$this->user->data->email){
        $answer[] = translate("tr_a23bf8ca60fd96fbbe314a0f57607ed7");
    }

    if(!$_POST["attach_files"]){
        $answer[] = translate("tr_c1ceac7d2dceaa0c7a340ba970f44e10");
    }

    if(empty($answer)){

        $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);

        $this->model->users_verifications->insert(["time_create"=>$this->datetime->getDate(), "user_id"=>$this->user->data->id, "media"=>_json_encode($_POST["attach_files"]), "status"=>"awaiting_verification", "uniq_code"=>$this->session->get("user-verification-code")]);

        $this->event->sendUserVerification(["user_id"=>$this->user->data->id]);

        return json_answer(["status"=>true]);
    }else{
        return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);
    }

}

public function verificationUploadAttach()
{   

    $result = '';

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->deleteOriginal(true)->encrypt(true)->use("resize")->upload();

    if($resultUpload){

        $result = '
          <div class="uni-attach-files-item-delete uniAttachFilesDeleteItem" ><i class="ti ti-x"></i></div>
          <img class="image-autofocus" src="'.$this->storage->getAssetImage("6383224500768844.webp").'" />
          <input type="hidden" name="attach_files[]" value="'.$resultUpload["name"].'" >
        ';

    }

    return json_answer(["content"=>$result]);
       
}

public function wallet()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    if(!$this->settings->profile_wallet_status){
        abort(404);
    }

    $data = (object)[];

    $data->history = $this->component->profile->outPaymentHistoryWallet();

    return $this->view->render('profile/wallet', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_419a0c4f19223bbef8fd1cbf92bf0cd0")]]);
}



 }