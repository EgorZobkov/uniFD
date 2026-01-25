<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Profile
{

 public $alias = "profile";

 public function actionsCode(){   
    global $app;

    $result["buy"] = ["code"=>"buy", "name"=>translate("tr_b00d3a26323497e7f7d36f8887262fd5"), "name_declension"=>translate("tr_bbf3a630e0e4258834b3fbe1b64e60bc")];
    $result["view_ad_contacts"] = ["code"=>"view_ad_contacts", "name"=>translate("tr_26c08f95bbf86858520c006b541d6999"), "name_declension"=>translate("tr_26c08f95bbf86858520c006b541d6999")];
    $result["add_to_cart"] = ["code"=>"add_to_cart", "name"=>translate("tr_bbc1105e6ea90058cfdb2575fa86b408"), "name_declension"=>translate("tr_fa7597ee61cdf0df8fb1083e5553589a")];
    $result["add_to_favorite"] = ["code"=>"add_to_favorite", "name"=>translate("tr_893d62d08d30f5c887cc7491447a0a01"), "name_declension"=>translate("tr_742e5067ef79ea070fbe835c2c29ea80")];
    $result["go_partner_link"] = ["code"=>"go_partner_link", "name"=>translate("tr_9906d2cd832b58290e07028aadbd560b"), "name_declension"=>translate("tr_2e79da4fd1063a4a02acf83b1643d847")];

    return $result;

}

public function addActionUser($params=[]){   
    global $app;

    if($params["from_user_id"] && $params["item_id"]){

        $ad = $app->model->ads_data->find("id=?", [$params["item_id"]]);

        if($ad){

            if(!$app->model->users_actions->find("from_user_id=? and whom_user_id=? and item_id=? and action_code=? and date(time_create)=?", [$params["from_user_id"], $ad->user_id, $params["item_id"], $params["action_code"], $app->datetime->format("Y-m-d")->getDate()])){

                $app->model->users_actions->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "action_code"=>$params["action_code"], "item_id"=>$params["item_id"]]);

            }

        }

    }       
    
}

public function addPaymentScore($user_id=0, $score=null){
    global $app;

    if($score){

        $payment = $app->component->transaction->getServiceSecureDeal();

        if($payment){
            if($payment->type_score == "score_card"){
                if(!detectBankCardType($score)){
                    return ["status"=>false, "answer"=>translate("tr_3cd07360d2fd670264e306f1fe58d3c8")];
                }                    
            }
        }else{
            if(!detectBankCardType($score)){
                return ["status"=>false, "answer"=>translate("tr_3cd07360d2fd670264e306f1fe58d3c8")];
            }
        }

        if(!$app->model->users_payment_data->find("score=? and user_id=?", [$score,$user_id])){

            $app->model->users_payment_data->insert(["user_id"=>$user_id, "type_score"=>$payment ? $payment->type_score : "score_card", "score"=>encrypt($score), "default_status"=>$app->model->users_payment_data->count("default_status=? and user_id=?", [1,$user_id]) ? 0 : 1]);

            return ["status"=>true];

        }else{
            return ["status"=>false, "answer"=>translate("tr_b93f5f3864fa383e2f3e0ac1758f153f")];
        }

    }else{
        return ["status"=>false, "answer"=>translate("tr_528a67adc943ea4fa07bf40c87be8294")];
    }

}

public function addToBlacklist($from_user_id=0, $whom_user_id=0, $channel_id=0){
    global $app;

    $getWhomUser = $app->model->users->find("id=?", [$whom_user_id]);

    if(!$getWhomUser){
        return false;
    }

    if($channel_id){
        $get = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=? and channel_id=?", [$from_user_id, $whom_user_id, $channel_id]);
    }else{
        $get = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=?", [$from_user_id, $whom_user_id]);
    }

    if($get){

        $app->model->users_blacklist->delete("id=?", [$get->id]);

        return false;

    }else{

        $app->model->users_blacklist->insert(["from_user_id"=>$from_user_id, "whom_user_id"=>$whom_user_id, "channel_id"=>(int)$channel_id]);

        return true;

    }

}

public function bonus($user_id=0){
    global $app;

    if($app->settings->registration_bonus_status){

        $app->component->transaction->manageUserBalance(["user_id"=>$user_id, "amount"=>$app->settings->registration_bonus_amount, "text"=>translate("tr_8d84a0cdf8be0221a8f814a68ef43b98")], "+");
    }

}

public function buildContacts($params=[]){
    global $app;
    return encrypt(_json_encode(["whatsapp"=>$params["whatsapp"],"telegram"=>trim($params["telegram"], "@"),"max"=>trim($params["max"], "@")]));
}

function calculateRating($user_id=0, $item_id=0){
     global $app;

     $array = [];
     $result = 0;

     $array["total_rating"] = 0;
     $array["rating_1"] = 0;
     $array["rating_2"] = 0;
     $array["rating_3"] = 0;
     $array["rating_4"] = 0;
     $array["rating_5"] = 0;

     if($item_id){
         $getReviews = $app->model->reviews->getAll("whom_user_id=? and item_id=? and status=?", [$user_id, $item_id, 1]);
     }else{
         $getReviews = $app->model->reviews->getAll("whom_user_id=? and status=?", [$user_id, 1]);
     }

     if($getReviews){
          foreach ($getReviews as $value) {
              $array["total_rating"] += $value["rating"];
              $array["rating_".$value["rating"]] += $value["rating"];
          }
      }

      $array["rating_1"] = $array["rating_1"] ? $array["rating_1"] : 0;
      $array["rating_2"] = $array["rating_2"] ? $array["rating_2"] : 0;
      $array["rating_3"] = $array["rating_3"] ? $array["rating_3"] : 0;
      $array["rating_4"] = $array["rating_4"] ? $array["rating_4"] : 0;
      $array["rating_5"] = $array["rating_5"] ? $array["rating_5"] : 0;

      if($array["total_rating"]){
         $result = ($array["rating_1"]*1+$array["rating_2"]*2+$array["rating_3"]*3+$array["rating_4"]*4+$array["rating_5"]*5)/$array["total_rating"];
      }

      if($result <= 5){
         return sprintf("%.1f", $result);
      }else{
         return 5.0;
      }

}

public function checkVerificationPermissions($user_id=0, $code=null){
    global $app;

    if($app->settings->verification_users_status){

        $user = $app->model->users->findById($user_id);

        if($user->verification_status){
            return true;
        }else{
            if(compareValues($app->settings->verification_users_permissions,$code)){
                return false;
            }else{
                return true;
            }
        }

    }

    return true;

}

public function fixAwardReferral($user_id=0, $amount=0){
    global $app;

    if(!$app->settings->referral_program_status){
        return;
    }

    $award = calculatePercent($amount, $app->settings->referral_program_percent_award);

    if($award){

        $referral = $app->model->users_referrals->find("from_user_id=?", [$user_id]);

        if($referral){

            $app->model->users_referral_award->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$user_id, "whom_user_id"=>$referral->whom_user_id, "amount"=>$award]);

            $app->component->transaction->manageUserBalance(["user_id"=>$referral->whom_user_id, "amount"=>$award], "+");

            $app->event->fixAwardReferral(["from_user_id"=>$user_id, "whom_user_id"=>$referral->whom_user_id, "amount"=>$award]);

        }

    }

}

public function fixReferral($user_id=0){
    global $app;

    if(!$app->settings->referral_program_status){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    $transition = $app->model->users_referral_transitions->find("session_id=?", [$session_id]);

    if($transition){
        if(!$app->model->users_referrals->find("from_user_id=? and whom_user_id=?", [$user_id,$transition->user_id])){
            $app->model->users_referrals->insert(["time_create"=>$app->datetime->getDate(), "from_user_id"=>$user_id, "whom_user_id"=>$transition->user_id]);
            $app->event->fixReferral(["from_user_id"=>$user_id, "whom_user_id"=>$transition->user_id]);
        }
    }

}

public function fixTransitionReferral($alias=null){
    global $app;

    if(!$app->settings->referral_program_status || !$alias){
        return;
    }

    $session_id = $app->session->get("user-session-id");

    $user = $app->model->users->find("alias=?", [$alias]);

    if($user){
        if($user->id != $app->user->data->id){
            if(!$app->model->users_referral_transitions->find("user_id=? and session_id=?", [$user->id,$session_id])){
                $app->model->users_referral_transitions->insert(["time_create"=>$app->datetime->getDate(), "user_id"=>$user->id, "session_id"=>$session_id, "ip"=>getIp()]);
            }
        }
    }

}

public function getActionCode($code=null){
    global $app;

    $actionCode = $this->actionsCode();

    return $actionCode[$code] ? (object)$actionCode[$code] : [];

}

public function getAddedReviews($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->reviews->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("from_user_id=? and parent_id=?", [$user_id,0]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/review-added-list.tpl');

        }
    }

    return $content;
    
}

public function getAllAdsUser($user_id=0, $status=null){   
    global $app;

    $content = '';
    $status_query = null;

    if($status == "active"){
        $status_query = '1';
    }elseif($status == "sold"){
        $status_query = '7';
    }elseif($status == "moderation"){
        $status_query = '0';
    }elseif($status == "waiting_payment"){
        $status_query = '5';
    }elseif($status == "archive"){
        $status_query = '2,3,4,8';
    }

    if(isset($status_query)){
        $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and status IN(".$status_query.")", [$user_id]);
    }else{
        $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=?", [$user_id]);
    }

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-list.tpl');

        }
    }

    return $content;
    
}

public function getAllAdsUserInCard($user_id=0, $status=null){   
    global $app;

    $content = '';
    $status_query = null;

    if($status == "active"){
        $status_query = '1';
    }elseif($status == "sold"){
        $status_query = '7';
    }else{
        $status_query = '1';
    }

    $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and status IN(".$status_query.")", [$user_id]);

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid.tpl');

        }
    }

    return $content;
    
}

public function getAllAwardsReferrals($user_id=0){   
    global $app;

    $content = '';
    
    $getUsers = $app->model->users_referral_award->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("whom_user_id=?", [$user_id]);

    if($getUsers){
        foreach ($getUsers as $key => $value) {
           
            $user = $app->model->users->find('id=?', [$value["from_user_id"]]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value, 'user'=>$user])->includeComponent('items/profile-referral-award-list.tpl');

        }
    }

    return $content;
    
}

public function getAllUsersReferrals($user_id=0){   
    global $app;

    $content = '';
    
    $getUsers = $app->model->users_referrals->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("whom_user_id=?", [$user_id]);

    if($getUsers){
        foreach ($getUsers as $key => $value) {
           
            $user = $app->model->users->find('id=?', [$value["from_user_id"]]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value, 'user'=>$user])->includeComponent('items/profile-referral-grid.tpl');

        }
    }

    return $content;
    
}

public function getFavorites($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_favorites->pagination(true)->page($_GET['page'])->output(60)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->ads->getAd($value["ad_id"]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-ads-grid.tpl');

        }
    }

    return $content;
    
}

public function getFromUserOrders($user_id=0){   
    global $app;

    $content = '';

    $getOrders = $app->model->transactions_deals->pagination(true)->page($_GET['page'])->output(10)->sort("time_update desc")->getAll("from_user_id=?", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
           
            $value = $app->component->transaction->getDataDealByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/order-list.tpl');

        }
    }

    return $content;
    
}

public function getHomeAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc limit 4")->getAll("user_id=?", [$user_id]);
    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/home-profile-grid.tpl');

        }
    }

    return $content;
    
}

public function getHomeAdsUserOnlyActive($user_id=0){   
    global $app;

    $content = '';

    $getAds = $app->model->ads_data->sort("id desc limit 4")->getAll("user_id=? and status=?", [$user_id, 1]);
    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/home-profile-grid.tpl');

        }
    }

    return $content;
    
}

public function getHomeFavoritesAdsUser($user_id=0){   
    global $app;

    $content = '';

    $getFavorites = $app->model->users_favorites->sort("id desc limit 4")->getAll("user_id=?", [$user_id]);
    if($getFavorites){
        foreach ($getFavorites as $key => $value) {
           
            $getAd = $app->component->ads->getAd($value["ad_id"]);
            if($getAd){
                $content .= $app->view->setParamsComponent(['value'=>$getAd])->includeComponent('items/home-profile-grid.tpl');
            }

        }
    }

    return $content;
    
}

public function getHomeOrdersUser($user_id=0){   
    global $app;

    $content = '';

    $getOrders = $app->model->transactions_deals->sort("time_update desc limit 4")->getAll("from_user_id=? or whom_user_id=?", [$user_id,$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
           
            $value = $app->component->transaction->getDataDealByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/order-grid.tpl');

        }
    }

    return $content;
    
}

public function getHomeReviews($user_id=0){   
    global $app;

    $content = '';

    $getReviews = $app->model->reviews->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$user_id,1,0]);

    if($getReviews){
        foreach ($getReviews as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/review-grid.tpl');

        }
    }

    return $content;
    
}

public function getMenu(){
    global $app;

    $result = [];

    $menu = $app->model->profile_menu->cacheKey(["parent_id"=>0])->sort("sorting asc")->getAll("parent_id=?", [0]);
    foreach ($menu as $key => $value) {
        if($value["submenu"]){
            $result[$value["id"]] = $value;
            $result[$value["id"]]["submenu"] = $app->model->profile_menu->cacheKey(["parent_id"=>$value["id"]])->sort("sorting asc")->getAll("parent_id=?", [$value["id"]]);
        }else{
            $result[$value["id"]] = $value;
        }
    }

    foreach ($result as $key => $value) {
        if($value["submenu"]){

            ?>
            <div class="dropdown-box-list-nested-toggle">
                <a href="#"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?> <i class="ti ti-chevron-down"></i></a>
                <div class="dropdown-box-list-nested" >
                <?php
                    foreach ($value["submenu"] as $subkey => $subvalue) {
                        if($subvalue["route_alias"] == "profile-shop"){
                            if($app->settings->shops_status){
                            ?>
                            <a href="<?php echo outRoute($subvalue["route_alias"]); ?>"><svg width="26" height="26"></svg> <?php echo translateField($subvalue["name"]); ?></a>
                            <?php
                            }
                        }else{
                            ?>
                            <a href="<?php echo outRoute($subvalue["route_alias"]); ?>"><svg width="26" height="26"></svg> <?php echo translateField($subvalue["name"]); ?></a>
                            <?php                                
                        }
                    }
                ?>
                </div>
            </div>
            <?php

        }else{
            if($value["route_alias"] == "profile-wallet"){
                if($app->settings->profile_wallet_status){
                    ?>
                    <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?> <strong><?php echo $app->user->data->balance_by_currency; ?></strong></a>
                    <?php
                }
            }elseif($value["route_alias"] == "profile-referral"){
                if($app->settings->referral_program_status && $app->settings->profile_wallet_status){
                    ?>
                    <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?></a>
                    <?php
                }
            }else{
                ?>
                <a href="<?php echo outRoute($value["route_alias"]); ?>"><?php echo $value["icon"]; ?> <?php echo translateField($value["name"]); ?></a>
                <?php                    
            }
        }
    }

}

public function getMyReviews($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->reviews->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$user_id,1,0]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/review-list.tpl');

        }
    }

    return $content;
    
}

public function getPaymentData($user_id=0){
    global $app;
    $payment = $app->model->users_payment_data->find("user_id=? and default_status=?", [$user_id, 1]);
    if($payment){
        $payment->score = decrypt($payment->score);
        $payment->service = $app->component->transaction->getServiceSecureDeal();
        return $payment;
    }
    return [];
}

public function getRenewalAdsUser($user_id=0){   
    global $app;

    $content = '';
    
    $getAds = $app->model->ads_data->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("user_id=? and auto_renewal_status=?", [$user_id, 1]);

    if($getAds){
        foreach ($getAds as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-ads-renewal-list.tpl');

        }
    }

    return $content;
    
}

public function getSearches($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_searches->pagination($_GET['page'],30)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {

            $geo = [];
            $category = [];

            if($value["category_id"]){
                $category = $app->component->ads_categories->categories[$value["category_id"]];
                if($category){
                    $category["chain"] = $app->component->ads_categories->chainCategory($value["category_id"]);
                }
            }

            if($value["city_id"]){
                $geo = $app->model->geo_cities->find("id=?", [$value["city_id"]]);
            }elseif($value["region_id"]){
                $geo = $app->model->geo_regions->find("id=?", [$value["region_id"]]);
            }elseif($value["country_id"]){
                $geo = $app->model->geo_countries->find("id=?", [$value["country_id"]]);
            }

            $value["params"] = $value["params"] ? _json_decode($value["params"]) : [];
           
            $content .= $app->view->setParamsComponent(['value'=>(object)$value, "category"=>(object)$category, "geo"=>$geo])->includeComponent('items/profile-searches-list.tpl');

        }
    }

    return $content;
    
}

public function getStatisticsChartMonth($item_id=0, $month=null, $year=null, $user_id=0, $date_format=null){   
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$item_id, $user_id]);

    if(!$ad){
        return [];
    }

    $actions = $this->actionsCode();

    if(!$ad->partner_link){
        unset($actions["go_partner_link"]);
    }

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    $y = !$year ? $app->datetime->format("Y")->getDate() : $year;
    $m = !$month ? $app->datetime->format("m")->getDate() : $month;            

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        foreach ($actions as $value) {

            $count = $app->model->users_actions->count("date(time_create)=? and action_code=? and item_id=?", [$date,$value["code"],$item_id]);

            if($count){
                $action_count[$value["name_declension"]][] = ["date"=>date($date_format ?: "d.M.Y", strtotime($date)), "count"=>$count]; 
            }else{
                $action_count[$value["name_declension"]][] = ["date"=>date($date_format ?: "d.M.Y", strtotime($date)), "count"=>0];
            }

        }

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}

public function getSubscriptions($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->users_subscriptions->pagination(true)->page($_GET['page'])->output(30)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {
           
            $user = $app->model->users->cacheKey(["id"=>$value["whom_user_id"]])->find("id=?", [$value["whom_user_id"]]);

            $content .= $app->view->setParamsComponent(['user'=>(object)$user])->includeComponent('items/user-grid.tpl');

        }
    }

    return $content;
    
}

public function getUserCard($user_id=0){
    global $app;

    $user = $app->model->users->findById($user_id);

    if($user){

        $user->service_tariff = $app->component->service_tariffs->getOrderByUserId($user->id);
        $user->shop = $app->component->shop->getActiveShopByUserId($user->id);

        if($user->shop){
            $user->name = $user->shop->title;
            $user->avatar_src = $app->storage->name($user->shop->image)->host(true)->get();
            $user->link = $app->component->shop->linkToShopCard($user->shop->alias);
        }else{
            $user->name = $app->user->name($user, true);
            $user->avatar_src = $app->storage->name($user->avatar)->host(true)->get();
            $user->link = $this->linkUserCard($user->alias);
        }

    }

    return $user;

}

public function getViewed($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->ads_views->pagination(true)->page($_GET['page'])->output(30)->sort("id desc")->getAll("user_id=?", [$user_id]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->ads->getAd($value["ad_id"]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/profile-ads-grid.tpl');

        }
    }

    return $content;
    
}

public function getWhomUserOrders($user_id=0){   
    global $app;

    $content = '';

    $getOrders = $app->model->transactions_deals->pagination(true)->page($_GET['page'])->output(10)->sort("time_update desc")->getAll("whom_user_id=?", [$user_id]);

    if($getOrders){
        foreach ($getOrders as $key => $value) {
           
            $value = $app->component->transaction->getDataDealByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/order-list.tpl');

        }
    }

    return $content;
    
}

public function inFavorite($ad_id=0, $user_id=0){   
    global $app;
    
    return $app->model->users_favorites->find("ad_id=? and user_id=?", [$ad_id, $user_id]) ? true : false;

}

public function isBlacklist($from_user_id=0, $whom_user_id=0, $channel_id=0){
    global $app;
    if($channel_id){
        $check = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=? and channel_id=?", [$from_user_id,$whom_user_id,$channel_id]);
    }else{
        $check = $app->model->users_blacklist->find("from_user_id=? and whom_user_id=?", [$from_user_id,$whom_user_id]);
    }
    if($check){
        return true;
    }
    return false;
}

public function isBlacklistСross($from_user_id=0, $whom_user_id=0){
    global $app;
    $check = $app->model->users_blacklist->find("(from_user_id=? and whom_user_id=?) or (whom_user_id=? and from_user_id=?)", [$from_user_id,$whom_user_id,$from_user_id,$whom_user_id]);
    if($check){
        return true;
    }
    return false;
}

public function isSavedSearch(){
    global $app;

    $params = [];

    $request_params = trim(getAllRequestURI(), "/");

    if($request_params){
        parse_str($request_params, $params);
    }

    $request = $app->session->get("request-catalog");
    $geo = $app->session->get("geo");

    $token = md5(urldecode($request_params));

    $check = $app->model->users_searches->find("user_id=? and token=?", [$app->user->data->id, $token]);
    if($check){
        return true;
    }
    return false;
}

public function isSubscription($from_user_id=0, $whom_user_id=0){
    global $app;
    if($app->model->users_subscriptions->find("user_id=? and whom_user_id=?", [$from_user_id,$whom_user_id])){
        return true;
    }
    return false;
}

public function linkUserCard($alias){
    global $app;

    return outRoute('user-card', [$alias]);

}

public function outAuthServices($button=false){
    global $app;

    if($app->settings->auth_services_list){
        $list = $app->model->system_oauth_services->getAll("id IN(".implode(",", $app->settings->auth_services_list).")");
        if($list){
            foreach ($list as $key => $value) {

                $instance = $app->addons->oauth($value["alias"]);

                if(!$button){
                    echo '<a href="'.$instance->buildLink().'" ><img src="'.$instance->logo().'" title="'.$value["name"].'"></a>';
                }else{
                    echo '<a class="btn-custom button-color-scheme2 button-color-'.$value["alias"].' width100" href="'.$instance->buildLink().'" >'.$value["name"].'</a>';
                }

            }
        }
    }

}

public function outAvatarStories($image=null, $user_id=0){
    global $app;

    $getStory = $app->model->stories_media->sort("time_create desc")->find("user_id=? and status=?", [$user_id, 1]);

    if($getStory){
    ?>

      <div>
        <div class="user-avatar-by-stories actionOpenModalUserStories" data-id="<?php echo $user_id; ?>" >
            <div class="<?php if(!$app->component->stories->checkViewStories($getStory->id, $app->user->data->id)){ ?>stories-border-no-view<?php } ?>" >
                <div class="user-avatar-by-stories-circle" >
                    <img class="image-autofocus" src="<?php echo $app->storage->name($image)->get(); ?>">
                </div>
            </div>
        </div>
      </div>

    <?php
    }else{
    ?>

      <div>
          <div class="user-avatar-by-stories" >
            <div>
                <div class="user-avatar-by-stories-circle" >
                    <img class="image-autofocus" src="<?php echo $app->storage->name($image)->get(); ?>">
                </div>
            </div>
          </div>
      </div>

    <?php            
    }

}

public function outCountAdsUserByStatus($status=null, $user_id=0){
    global $app;

    if(!$user_id){
        $user_id = $app->user->data->id;
    }

    if($status == "active"){
        $status = '1';
    }elseif($status == "sold"){
        $status = '7';
    }elseif($status == "moderation"){
        $status = '0';
    }elseif($status == "waiting_payment"){
        $status = '5';
    }elseif($status == "archive"){
        $status = '2,3,4,8';
    }

    if(isset($status)){
        $count = $app->model->ads_data->count("user_id=? and status IN(".$status.")", [$user_id]);
    }else{
        $count = $app->model->ads_data->count("user_id=?", [$user_id]);
    }

    return $count ?: '';

}

public function outFaceCard($data=[]){
    global $app;

    $user = $app->model->users->cacheKey(["id"=>$data->user->id])->find('id=?', [$data->user->id]);
    
    if($user){
        return '
        <div class="box-user-face-card">
                
            <div class="box-user-face-card-avatar">
              
                <div>
                  <img class="image-autofocus" src="'.$app->storage->name($user->avatar)->get().'">
                </div>

            </div>

            <div class="box-user-face-card-content">

                 '.$app->user->name($user).' '.$this->verificationLabel($user->verification_status).'
                
            </div>

        </div>
        ';
    }

}

public function outMethodAddScoreUser($user_id=0){
    global $app;

    $payment = $app->component->transaction->getServiceSecureDeal();
    
    if($payment->type_score != "add_card"){
        return '
          <div class="credit-card-add openModal" data-modal-id="addPaymentScoreModal" >
              <div>'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</div>
          </div>
        ';
    }else{

        if(!$app->model->users_payment_data->find("user_id=? and type_score=?", [$user_id, "add_card"])){
            return '
              <div class="credit-card-add actionAddPaymentCardToLink" >
                  <div>'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</div>
              </div>
            ';
        }
        
    }

}

public function outPaymentHistoryWallet(){
    global $app;

    $result  = '';

    $getHistory = $app->model->transactions->sort("id desc")->getAll("user_id=? and status_payment=?", [$app->user->data->id,1]);
    if($getHistory){

        $result .= '
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr>
                <th><span>'.translate("tr_c4666dd6229b9f6cdc544a0b5ab4cb0a").'</span></th>
                <th><span>'.translate("tr_cf59ebf9edf7ebe3ece76645abb6de12").'</span></th>
                <th><span>'.translate("tr_8cdd8bb771bcf038dfb2740fd50b332c").'</span></th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
        ';

        foreach ($getHistory as $key => $value) {

            $result .= '
                <tr>
                  <td>'.$app->component->transaction->getTitleByTemplateAction(_json_decode(decrypt($value["data"]))).'</td>
                  <td>'.$app->system->amount($value["amount"], $value["currency_code"]).'</td>
                  <td>'.$app->datetime->outDateTime($value["time_create"]).'</td>
                </tr>
            ';

        }

        $result .= '   
            </tbody>
          </table>
        </div>
        ';

    }

    return $result;

}

public function outShippingPointsList(){
    global $app;
    
    $points = $app->model->users_shipping_points->getAll("user_id=?", [$app->user->data->id]);

    if($points){
        foreach ($points as $key => $value) {
           $delivery = $app->model->system_delivery_services->find("id=?", [$value["delivery_id"]]);
           if($delivery){
               ?>
               <div>
                   <img src="<?php echo $app->addons->delivery($delivery->alias)->logo(); ?>" height="30px" >
                   <div><?php echo $value["address"]; ?></div>
               </div>
               <?php
           }
        }
    }

}

public function outStarsRating($rating=0){

    global $app;

    if(intval($rating)){
        if(intval($rating) == 1){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 2){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 3){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';
        }elseif(intval($rating) == 4){
          return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star"></i></span>
          ';            
        }elseif(intval($rating) == 5){
           return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
           ';            
        }else{
           return '
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
                 <span><i class="ti ti-star-filled"></i></span>
           ';                
        }
    }else{
        return '
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
             <span><i class="ti ti-star"></i></span>
       ';
    }

}

public function outTotalReviews($total_reviews=0){
    global $app;
    return $total_reviews . ' ' . endingWord($total_reviews, translate("tr_22c585f75c24d937f90165dc341b1dbd"), translate("tr_702db99a476541dc4de2d765ee4653ac"), translate("tr_cb704af04e2a3ac14a6eae2f02251d72"));
}

public function outUserAdStatistics($item_id=0, $user_id=0){   
    global $app;

    $content = '';

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$item_id, $user_id]);
    $actions = $app->model->users_actions->pagination(true)->page($_GET['page'])->output(20)->sort("id desc")->filter(["date_start"=>$_GET['date_start'], "date_end"=>$_GET['date_end']])->getAll("item_id=? and whom_user_id=?", [$item_id,$user_id]);

    if($ad){

        ?>

        <p><?php echo translate("tr_cbb8b49fe24232cbd0bd1ab287dd34fa"); ?> <strong><?php echo $ad->title; ?></strong> </p>

        <?php echo $this->outUserAdStatisticsByMonth($item_id, $_GET["month"],$_GET["year"]); ?>

        <div class="profile-statistics-chart" id="profile-statistics-chart" ></div>  

        <h3 class="mt15 mb30" > <strong><?php echo translate("tr_fb3df31bf52df6c142a279ecdb6dd94c"); ?></strong> </h3>

        <?php
        
        if($_GET['date_start'] && $_GET['date_end']){
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a") . ': ' . $app->datetime->outDate($_GET['date_start']) . '-' . $app->datetime->outDate($_GET['date_end']); ?></div>
            <?php
        }elseif($_GET['date_start']){
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a") . ': ' . $app->datetime->outDate($_GET['date_start']); ?></div>
            <?php
        }else{
            ?>
            <div class="btn-custom-mini button-color-scheme2 mb20 openModal" data-modal-id="profileStatisticsChangeDateModal" ><?php echo translate("tr_28b76906f14ac4b4d584dfb15226b05a"); ?></div>
            <?php
        }

        if($actions){

        foreach ($actions as $key => $value) {

            $user = $app->model->users->cacheKey(["id"=>$value["from_user_id"]])->find('id=?', [$value["from_user_id"]]);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value, 'user'=>$user])->includeComponent('items/profile-statistics-actions-list.tpl');

        }

        echo $content;

        echo $app->pagination->display();

        }

    }else{
        ?>
        <p><?php echo translate("tr_29735b4fc08617ddb7b1766a9cc8001b"); ?></p>
        <?php
    }
    
}

public function outUserAdStatisticsByMonth($item_id=0, $month=null,$year=null){
    global $app;

    $result = "";

    if(!$year){
        $year = $app->datetime->format("Y")->getDate();
    }

    if(!$month){
        $month = abs($app->datetime->format("m")->getDate());
    }

    $x=0;
    while ($x++<12){

       $active = "";

       if(compareValues($year.'-'.$month, $year.'-'.$x)){
            $active = "active";
       }

       $result .= '
           <a class="transactions-statistics-month-list-item '.$active.'" href="?item_id='.$item_id.'&month='.$x.'&year='.$year.'" >
             <strong>'.$app->datetime->getCurrentNameMonth($x).', '.$year.'</strong>
           </a>
       ';

    }

    return $result;

}

public function outUserAdsAndSearchInStatistics($user_id=0){   
    global $app;

    $items = $app->model->ads_data->sort("id desc limit 3")->getAll("user_id=? and status IN(1,3,7)", [$user_id]);

    if($items){

        ?>

        <input type="text" class="form-control user-statistics-items-search" placeholder="<?php echo translate("tr_ff8ef34ca636fa06f0c6e3f3ceae279a"); ?>" >

        <div class="user-items-container mt15" >

          <?php foreach ($items as $item){ ?>
          <a class="user-item-container" href="<?php echo outRoute('profile-statistics'); ?>?item_id=<?php echo $item["id"]; ?>" >
              <div class="user-item-container-box1" >
                 <div class="user-item-container-image" >
                    <img src="<?php echo $app->component->ads->getMedia($item["media"])->images->first; ?>" class="image-autofocus" >
                 </div>
              </div>
              <div class="user-item-container-box2" >
                 <span><?php echo $item["title"]; ?></span>
                 <span><?php echo $app->component->ads->outPriceAndCurrency($item); ?></span>
              </div>
          </a>
          <?php } ?>

        </div>

        <?php

    }else{
        ?>

          <div class="mt20 not-found-title-container" >
             <div class="not-found-title-container-image" >🧐</div>
             <p><?php echo translate("tr_698ee392dad3099a37dae5c98118fb2d"); ?></p>           
          </div>            

        <?php
    }
    
}

public function outUserScoreList($user_id=0){
    global $app;
    $payments = $app->model->users_payment_data->getAll("user_id=?", [$user_id]);
    if($payments){
        foreach ($payments as $key => $value) {
            $value["score"] = decrypt($value["score"]);
            ?>
              <div class="credit-card selectable">
                  <span class="actionAddDefaultPaymentScore" data-id="<?php echo $value["id"]; ?>" > <?php if($value["default_status"]){ ?> <i class="ti ti-target active-yellow"></i> <?php }else{ ?> <i class="ti ti-target"></i> <?php } ?></span>
                  <span class="actionDeletePaymentScore" data-id="<?php echo $value["id"]; ?>" ><i class="ti ti-trash"></i></span>
                  <div class="credit-card-last4">
                      <?php echo substr($value["score"], strlen($value["score"])-4, strlen($value["score"])); ?>
                  </div>
              </div>
            <?php
        }
    }
}

public function saveCatalogSearch($params=[], $user_id=0){   
    global $app;

    if($params){
        if(!is_array($params)){
            $params = [];
        }
    }

    $request = $app->session->get("request-catalog");
    $geo = $app->session->get("geo");
    $link = trim(str_replace("&amp;", "&", urldecode($params["link"])), "/");

    if($app->config->app->prefix_path){

        $uri_explode = explode("/", $link);

        if($uri_explode[0] == $app->config->app->prefix_path){
            unset($uri_explode[0]);
        }

        $link = implode("/", $uri_explode);

    }

    $token = md5($link ?: null);

    $get = $app->model->users_searches->find("user_id=? and token=?", [$user_id, $token]);

    if($get){
        $app->model->users_searches->delete("id=?", [$get->id]);
        return ["answer"=>translate("tr_7f28e84837e808158a5d73734f7e7d7a"), "label"=>translate("tr_852be42059679d4e4fef58aad5f3fa2f")];
    }else{
        $app->model->users_searches->insert(["user_id"=>$user_id, "time_create"=>$app->datetime->getDate(), "params"=>$params ? _json_encode($params) : null, "category_id"=>$request->category_id?:0, "city_id"=>$geo->city_id?:0, "region_id"=>$geo->region_id?:0, "country_id"=>$geo->country_id?:0,"token"=>$token, "link"=>$link ?: null]);
        return ["answer"=>translate("tr_35e32673f23298102ec36862d57f0154"), "label"=>translate("tr_f6acf24dca325b44869ec3fe34ef5083")];
    }

}

public function stampCountRating($total_rating=0){
    global $app;

    return '<span class="stamp-user-rating" ><i class="ti ti-star-filled"></i> '.$total_rating.'</span>';

}

public function totalAwardReferral($user_id=0){
    global $app;
    $total = $app->db->getSumByTotal("amount", "uni_users_referral_award", "whom_user_id=?", [$user_id]);
    return $app->system->amount($total);
}

public function totalCountTransitionsReferral($user_id=0){
    global $app;
    return $app->model->users_referral_transitions->count("user_id=?", [$user_id]);
}

public function updateRatingAndReviews($user_id=0){
    global $app;

    $total = $app->model->reviews->count("whom_user_id=? and status=?", [$user_id, 1]);
    $app->model->users->cacheKey(["id"=>$user_id])->update(["total_rating"=>$this->calculateRating($user_id), "total_reviews"=>$total], $user_id);

}

public function verificationLabel($status=0){
    global $app;
    
    if($status){
        return '<span class="user-label-verification actionOpenStaticModal" data-modal-target="verificationUserInfo" ><i class="ti ti-square-rounded-check"></i></span>';
    }

}



}