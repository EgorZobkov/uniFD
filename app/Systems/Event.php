<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class Event
 {

 public $data = [];
 public $user = [];
 
 public function addComplaintAd($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_add_complaint_ad")->addWaiting();

}

public function addComplaintUser($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_add_complaint_user")->addWaiting();

}

public function addPaidService($data = []){
    global $app;

}

public function addServiceTariff($data = []){
    global $app;

}

public function addStories($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_add_stories")->addWaiting();

}

public function addToCart($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["item_id"], "action_code"=>"add_to_cart"]);
}

public function addToFavorite($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["user_id"], "item_id"=>$data["ad_id"], "action_code"=>"add_to_favorite"]);

}

public function authorizationUser($data = []){
    global $app;


}

public function blockingAd($data = []){
    global $app;

    $app->notify->params(["ad_title"=>$data->title, "ad_link"=>$app->component->ads->buildAliasesAdCard($data), "text"=>$data->reason_text])->userId($data->user->id)->code("board_ad_blocked")->addWaiting(); 

}

public function changeStatusReview($data = []){
    global $app;

    $app->component->chat->sendAction("new_review", ["from_user_id"=>$data["from_user_id"], "ad_id"=>$data["item_id"], "whom_user_id"=>$data["whom_user_id"]], false);

}

public function changeStatusShop($data = []){
    global $app;

    if($data["status"] == "published"){
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_shop_published")->addWaiting();
    }else{
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_shop_rejected")->addWaiting();
    }

}

public function changeStatusUserVerification($data = []){
    global $app;

    if($data["status"] == "verified"){
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_verification_verified")->addWaiting();
    }else{
        $app->notify->params((array)$data)->userId($data["user_id"])->code("user_verification_rejected")->addWaiting();
    }

}

public function createAd($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_create_ad")->addWaiting();

}

public function createOrderBooking($data = []){
    global $app;

    $app->component->chat->sendAction("system_create_order", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"], "ad_id"=>$data["item_id"]], false);
    $app->notify->params((array)$data)->userId($data["whom_user_id"])->code("create_order_booking")->addWaiting();

}

public function createResponseReview($data = []){
    global $app;

    $app->component->chat->sendAction("response_review", ["from_user_id"=>$data["from_user_id"], "ad_id"=>$data["item_id"], "whom_user_id"=>$data["whom_user_id"]], false);

}

public function createReview($data = []){
    global $app;

    if(!$app->settings->reviews_publication_moderation_status){
        $app->component->chat->sendAction("new_review", ["from_user_id"=>$data["from_user_id"], "ad_id"=>$data["item_id"], "whom_user_id"=>$data["whom_user_id"]], false);
    }

    $app->notify->params((array)$data)->code("system_create_review")->addWaiting();

}

public function createShop($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_open_shop")->addWaiting();

}

public function createTransaction($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_new_transaction")->addWaiting();

}

public function createUser($data = []){
    global $app;

    $app->component->chat->sendAction("system_registration", ["whom_user_id"=>$data["user_id"]], false);
    $app->component->profile->bonus($data["user_id"]);
    $app->component->profile->fixReferral($data["user_id"]);
    $app->notify->params((array)$data)->code("system_new_users")->addWaiting();

}

public function deleteUser($data = []){
    global $app;

}

public function editShop($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_edit_shop")->addWaiting();
}

public function extendServiceTariff($data = []){
    global $app;

}

public function fixAwardReferral($data = []){
    global $app;

    $app->notify->params(["amount"=>$app->system->amount($data["amount"])])->userId($data["whom_user_id"])->code("referral_accrued_award")->addWaiting();

}

public function fixReferral($data = []){
    global $app;


}

public function goPartnerLink($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["ad_id"], "action_code"=>"go_partner_link"]);

}

public function openDisputeDeal($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_open_dispute_deal")->addWaiting();

}

public function paymentOrderDeal($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["item_id"], "count"=>$data["count"], "action_code"=>"buy"]);
    $app->component->chat->sendAction("system_create_order", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"], "ad_id"=>$data["item_id"]], false);
    $app->notify->params((array)$data)->userId($data["whom_user_id"])->code("payment_order_deal")->addWaiting();

}

public function publicationAd($data = []){
    global $app;

    $app->notify->params(["ad_title"=>$data->title, "ad_link"=>$app->component->ads->buildAliasesAdCard($data)])->userId($data->user->id)->code("board_ad_active")->addWaiting();

}

public function replenishmentBalanceUser($data = []){
    global $app;
    
    $app->notify->params((array)$data)->userId($data["user_id"])->code("user_balance_replenishment")->addWaiting();

}

public function sendMessageChat($data = []){
    global $app;

    if($data["whom_user_id"] == 0){
        $app->component->chat->sendAction("first_message_support", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"]], false);
    }

    if($app->component->chat->hasContactInformationInMessage($data["text"])){
        $app->component->chat->sendAction("system_warning_contacts", ["from_user_id"=>$data["from_user_id"], "whom_user_id"=>$data["whom_user_id"], "ad_id"=>$data["ad_id"]], false);
    }
    
}

public function sendUserVerification($data = []){
    global $app;

    $app->notify->params((array)$data)->code("system_new_user_verification")->addWaiting();

}

public function showAdContacts($data = []){
    global $app;

    $app->component->profile->addActionUser(["from_user_id"=>$data["from_user_id"], "item_id"=>$data["ad_id"], "action_code"=>"view_ad_contacts"]);

}

public function subscribeUser($data = []){
    global $app;

}

public function writedownBalanceUser($data = []){
    global $app;
    
    $app->notify->params((array)$data)->userId($data["user_id"])->code("user_balance_write_downs")->addWaiting();

}



 }