public function managerModal($modal_id=null, $data=[]){
    global $app;

    $content = '';

    if($modal_id == "userComplain"){
        $this->tpl('modals/user-complain-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "adComplain"){
        $this->tpl('modals/ad-complain-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "adShare"){
        $this->tpl('modals/ad-share-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "responseReview"){
        $this->tpl('modals/response-review-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "editShop"){
        $this->tpl('modals/edit-shop-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "addPageShop"){
        $this->tpl('modals/add-page-shop-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "accountBlocked"){
        $this->tpl('modals/account-blocked.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "filters"){
        $this->tpl('modals/filters-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "geo"){
        $this->tpl('modals/geo-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "auth"){
        $this->tpl('form-auth.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "authForgot"){
        $this->tpl('form-auth-forgot.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "captcha"){
        $this->tpl('modals/captcha.tpl');
        $content = $this->modal($modal_id, "nano", $data);
    }elseif($modal_id == "payment"){
        $this->tpl('modals/payment-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "verificationUser"){
        $this->tpl('modals/verification-user-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "chat"){
        $this->tpl('profile/chat/modal.tpl');
        $content = $this->modal($modal_id, "big", $data);
    }elseif($modal_id == "verificationCode"){
        $this->tpl('modals/verification-code-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "openShop"){
        $this->tpl('modals/open-shop-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "adRemovePublication"){
        $this->tpl('modals/ad-remove-publication-modal.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "profileChangePassword"){
        $this->tpl('modals/profile-change-password.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "profileStatisticsChangeAd"){
        $this->tpl('modals/profile-statistics-change-ad.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "verificationUserInfo"){
        $this->tpl('modals/verification-user-info.tpl');
        $content = $this->modal($modal_id, "small", $data);
    }elseif($modal_id == "shopCategories"){
        $this->tpl('modals/shop-categories-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "bookingOrder"){
        $this->tpl('modals/booking-order-modal.tpl');
        $content = $this->modal($modal_id, "big", $data);
    }elseif($modal_id == "infoAdStatUsers"){
        $this->tpl('modals/info-ad-stat-users-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "deliveryPoints"){
        $this->tpl('modals/delivery-points-modal.tpl');
        $content = $this->modal($modal_id, "mega", $data);
    }elseif($modal_id == "cartChangeDelivery"){
        $this->tpl('modals/cart-change-delivery-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "deliveryHistory"){
        $this->tpl('modals/delivery-history-modal.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }elseif($modal_id == "adPaidServicesSearchUserItems"){
        $this->tpl('modals/ad-paid-services-search-user-items.tpl');
        $content = $this->modal($modal_id, "medium", $data);
    }

    return $content;

}