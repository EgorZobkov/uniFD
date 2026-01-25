<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Systems;

 class Ui
 {

 public $data = [];
 public $user = [];
 
 public function buildUniSelect($items=[], $params=[]){
  global $app;

  $itemsList = '';
  $searchBox = '';

  if($params["view"] == "multi"){

     foreach ($items as $key => $value) { 

          $checked = '';
          $active = '';

          if($params["selected"]){
             if(compareValues($params["selected"],$value["input_value"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="checkbox" name="'.$value["input_name"].'" value="'.$value["input_value"].'" '.$checked.' />
                      <span>
                        '.$value["item_name"].'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }

      return '
            <div class="uni-select" data-status="0" >
                <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
                <div class="uni-select-content" >
                  '.$searchBox.'
                  <div class="uni-select-content-container" >
                    '.$itemsList.'
                  </div>
                </div>
            </div>
      ';

  }elseif($params["view"]== "radio"){ 

     if($params["no_selected"]){
        $noSelected = '
              <label class="uni-select-content-item" >
                    <input type="radio" name="'.$params["no_selected"]["input_name"].'" value="'.$params["no_selected"]["input_value"].'" />
                    <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              </label>
        ';
     }else{
        $noSelected = '
              <label class="uni-select-content-item" >
                    <input type="radio" value="null" />
                    <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              </label>
        ';
     }

     foreach ($items as $key => $value) {

          $checked = ''; 
          $active = '';

          if($params["selected"]){
             if(compareValues($params["selected"],$value["input_value"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="radio" name="'.$value["input_name"].'" value="'.$value["input_value"].'" '.$checked.' />
                      <span>
                        '.$value["item_name"].'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }

    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              <div class="uni-select-content" >
                '.$searchBox.'
                <div class="uni-select-content-container" >
                  '.$noSelected.'
                  '.$itemsList.'
                </div>
              </div>
          </div>
    ';

  }elseif($params["view"] == "input"){

    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'" >'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'</span>
              <div class="uni-select-content" >
                  <div class="uni-select-content-input" >
                      <div class="row" >
                          <div class="col-6" ><input type="number" class="form-control" data-type="from" name="'.$value["name_from"].'" value="'.$value["value_from"].'" placeholder="'.translate("tr_996b125bc9bba860718d999df2ecc61d").'" /></div>
                          <div class="col-6" ><input type="number" class="form-control" data-type="to" name="'.$value["name_to"].'" value="'.$value["value_to"].'" placeholder="'.translate("tr_c2aa9c0cecea49717bb2439da36a7387").'" /></div>
                      </div>
                  </div>
              </div>
          </div>
    ';

  }


}

public function buildUniSelectFilters($items=[], $params=[]){
  global $app;

  $itemsList = '';
  $searchBox = '';

  if($params["view"] == "multi"){

     foreach ($items as $key => $value) {

          $checked = ''; $active = '';
          if($params["filter"]){
             if(compareValues($params["filter"][$value["filter_id"]],$value["id"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="checkbox" name="'.$params["input_name"].'" value="'.$value["id"].'" '.$checked.' />
                      <span>
                        '.translateFieldReplace($value, "name").'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }

      return '
            <div class="uni-select" data-status="0" >
                <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
                <div class="uni-select-content" >
                  '.$searchBox.'
                  <div class="uni-select-content-container" >
                    '.$itemsList.'
                  </div>
                </div>
            </div>
      ';

  }elseif($params["view"]== "radio"){

     foreach ($items as $key => $value) {

          $checked = ''; $active = '';
          if($params["filter"]){
             if(compareValues($params["filter"][$value["filter_id"]],$value["id"])){
                $checked = 'checked=""';
                $active = 'uni-select-item-active';
             }
          }

          $itemsList .= '
                <label class="uni-select-content-item '.$active.'" >
                      <input type="radio" name="'.$params["input_name"].'" value="'.$value["id"].'" '.$checked.' />
                      <span>
                        '.translateFieldReplace($value, "name").'
                      </span>
                </label>
          ';

     }

     if(count($items) > 10){
       $searchBox = '
            <div class="uni-select-content-search" >
                <input type="text" class="form-control" placeholder="'.translate("tr_bfc95980634bf529e8a406db2c842b31").'" />
            </div>
       ';
     }


    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_591cca300870eb571563ef4b8c8756ff").'" >'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
              <div class="uni-select-content" >
                '.$searchBox.'
                <div class="uni-select-content-container" >
                  <label class="uni-select-content-item" >
                        <input type="radio" value="null" />
                        <span>'.translate("tr_591cca300870eb571563ef4b8c8756ff").'</span>
                  </label>
                  '.$itemsList.'
                </div>
              </div>
          </div>
    ';

  }elseif($params["view"] == "input"){

    $inputs = '';

    if($items["input_name_from"] && $items["input_name_to"]){
        $inputs = '
          <div class="col-6" ><input type="number" class="form-control" data-type="from" name="'.$items["input_name_from"].'" value="'.$items["input_value_from"].'" placeholder="'.translate("tr_996b125bc9bba860718d999df2ecc61d").'" /></div>
          <div class="col-6" ><input type="number" class="form-control" data-type="to" name="'.$items["input_name_to"].'" value="'.$items["input_value_to"].'" placeholder="'.translate("tr_c2aa9c0cecea49717bb2439da36a7387").'" /></div>
        ';
    }elseif($items["input_name"]){
        $inputs = '
          <div class="col-12" ><input type="text" class="form-control" data-type="text" name="'.$items["input_name"].'" value="'.$items["input_value"].'" placeholder="'.translate("tr_22bbd9c9cc3f2db273ee25775659eed9").'" /></div>
        ';            
    }
    

    return '
          <div class="uni-select" data-status="0" >
              <span class="uni-select-name" data-default-name="'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'" >'.translate("tr_7cddffa0460d1dab9bc69880f9201c2a").'</span>
              <div class="uni-select-content" >
                  <div class="uni-select-content-input" >
                      <div class="row" >
                          '.$inputs.'
                      </div>
                  </div>
              </div>
          </div>
    ';

  }


}

public function managerFiles($params=[]){
    global $app;

    if($params["input_name"]){
        $input_name = $params["input_name"];
    }else{
        $input_name = "manager_image";
    }
    
    if($app->storage->name($params["filename"])->exist()){

        return '
          <div class="filemanager-frontend" >

            <span class="btn btn-sm btn-primary filemanager-frontend-change" data-path="'.$params["path"].'" >'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</span>

            <div class="filemanager-frontend-container" style="display: block;" >
              <span class="filemanager-frontend-item-delete" ><i class="ti ti-trash-x"></i></span>
              <img src="'.$app->storage->name($params["filename"])->get().'" class="image-autofocus" >
            </div>

            <input type="hidden" name="'.$input_name.'" value="'.$params["filename"].'" />

          </div>
          <label class="form-label-error" data-name="'.$input_name.'" ></label>
        ';               

    }else{

        return '
          <div class="filemanager-frontend" >
             <span class="btn btn-sm btn-primary filemanager-frontend-change" >'.translate("tr_5eba283b81890978e67f4aa96dde1724").'</span>
             <div class="filemanager-frontend-container" ></div>
             <input type="hidden" name="'.$input_name.'" value="" />
          </div>
          <label class="form-label-error" data-name="'.$input_name.'" ></label>
        ';

    }

}

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

public function metaCsrf(){
    global $app;

    $token = generationCsrfToken();

    return '<meta name="csrf-token" content="'.$token.'">';

}

public function modal($id=null, $size="medium", $data=[]){
    global $app;

    $tpl = $this->tpl;
    $this->tpl = null;

    if(isset($tpl)){

        return '
          <div class="modal fade" id="'.$id.'Modal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down" style="'.$this->modalSize($size).'">
            <div class="modal-content">
              <button type="button" class="btn-close closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
              '.$app->view->setParamsComponent(["data"=>(object)$data])->includeComponent($tpl).'
              </div>
            </div>
          </div>
          </div>
        ';            

    }

}

public function modalSize($id=null){
    if($id == "nano"){
        return "max-width: 450px!important;";
    }elseif($id == "small"){
        return "max-width: 550px!important;";
    }elseif($id == "medium"){
        return "max-width: 650px!important;";
    }elseif($id == "big"){
        return "max-width: 750px!important;";
    }elseif($id == "mega"){
        return "max-width: 950px!important;";
    }else{
        return "max-width: ".$id."!important;";
    }
}

public function outAcceptUploadFormatFiles($group_formats=null){
    global $app;

    $result = [];

    if($group_formats == "multiple"){

        foreach ($app->settings->allowed_extensions_images as $key => $value) {
            $result[] = "image/".$value;
        }

        foreach ($app->settings->allowed_extensions_videos as $key => $value) {
            $result[] = "video/".$value;
        }

    }elseif($group_formats == "image"){

        foreach ($app->settings->allowed_extensions_images as $key => $value) {
            $result[] = "image/".$value;
        }

    }elseif($group_formats == "video"){

        foreach ($app->settings->allowed_extensions_videos as $key => $value) {
            $result[] = "video/".$value;
        }

    }

    return 'accept="'.implode(",", $result).'"';

}

function outContactSocialLinks(){
   global $app;

   $result = '';

   if($app->settings->contact_social_links){
      foreach ($app->settings->contact_social_links as $value) {
        if($value["link"] && $value["image"]){
          $result .= '
             <a class="contact-social-icon" href="'.$value["link"].'" target="_blank" >
               <img src="'.$value["image"].'" >
             </a>
          ';
        }
      }
   }

   return $result;

}

public function outHintAuth(){
    global $app;

    if($app->settings->registration_authorization_method == "email-phone"){
        return translate("tr_67447516ca358807f932af8f1f6b5382");
    }

    if($app->settings->registration_authorization_method == "email"){
        return translate("tr_3fad34c27c3081915cd17c2537551da0");
    }
       
    if($app->settings->registration_authorization_method == "phone"){
        return translate("tr_2afc9a58330df7d927a3f146028092ac");
    }

    if($app->settings->registration_authorization_method == "services"){
        return translate("tr_03b84f2ef87ed6858a43803016b6f643");
    }

}

public function outInputLogin(){
    global $app;

    if($app->settings->registration_authorization_method == "email-phone"){
        return '
        <input type="text" class="form-control" placeholder="'.translate("tr_6d583882982109ecefdc7c553d3fdef7").'" name="auth_login">
        <label class="form-label-error" data-name="auth_login" ></label>
        ';
    }

    if($app->settings->registration_authorization_method == "email"){
        return '
        <input type="text" class="form-control" placeholder="'.translate("tr_92d65fa726a6a4b889597e2e0b1efa58").'" name="auth_login">
        <label class="form-label-error" data-name="auth_login" ></label>
        ';
    }
       
    if($app->settings->registration_authorization_method == "phone"){

        if($app->system->multiPhonesStatus()){

            $phones = $app->system->getPhones();
            if($phones){
                foreach ($phones as $key => $value) {
                    $items .= '<span data-code="+'.$value->code.'" data-format="'.$value->template.'" data-icon="'.$app->storage->name($value->icon)->host(true)->get().'" ><img src="'.$app->storage->name($value->icon)->host(true)->get().'" /> '.$value->country.' +'.$value->code.'</span>';
                }
            }

            return '
              <div class="input-phone-countries-container" >
                  <div class="input-phone-countries-items" > <span class="input-phone-countries-change-item" ><img src="'.$app->storage->name($app->system->getDefaultPhoneTemplate()->icon)->host(true)->get().'" /> +'.$app->system->getDefaultPhoneTemplate()->code.'</span> <div class="input-phone-countries-items-container" >'.$items.'</div> </div>
                  <div class="input-phone-countries" ><input type="text" name="auth_login" class="form-control phoneMask" placeholder="'.$app->system->getDefaultPhoneTemplate()->template.'" data-phone-template="'.$app->system->getDefaultPhoneTemplate()->template.'" /></div>
              </div>
              <label class="form-label-error" data-name="auth_login" ></label>
            ';
        }else{
            return '
              <input type="text" name="auth_login" class="form-control phoneMask" placeholder="'.$app->system->getPhoneTemplate()->template.'" data-phone-template="'.$app->system->getPhoneTemplate()->template.'" />
              <label class="form-label-error" data-name="auth_login" ></label>
            ';
        }

    }

}

public function outInputPaymentScore($payment_service=[]){
    global $app;

    if($payment_service->type_score == "score_card"){
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php
    }elseif($payment_service->type_score == "score_wallet"){
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php
    }else{
        ?>
        <input type="text" name="payment_score" class="form-control" placeholder="<?php echo $payment_service->type_score_name; ?>" >
        <?php        
    }

}

public function outInputPhoneContact($phone='', $params=[]){
    global $app;

    if($app->system->multiPhonesStatus()){

        $phones = $app->system->getPhones();
        if($phones){
            foreach ($phones as $key => $value) {
                $items .= '<span data-code="+'.$value->code.'" data-format="'.$value->template.'" data-icon="'.$app->storage->name($value->icon)->host(true)->get().'" ><img src="'.$app->storage->name($value->icon)->host(true)->get().'" /> '.$value->country.' +'.$value->code.'</span>';
            }
        }

        return '
          <div class="input-phone-countries-container" >
              <div class="input-phone-countries-items" > <span class="input-phone-countries-change-item" ><img src="'.$app->storage->name($app->system->getDefaultPhoneTemplate()->icon)->host(true)->get().'" /> +'.$app->system->getDefaultPhoneTemplate()->code.'</span> <div class="input-phone-countries-items-container" >'.$items.'</div> </div>
              <div class="input-phone-countries" ><input type="text" name="'.$params["input_name"].'" class="form-control phoneMask" placeholder="'.$app->system->getDefaultPhoneTemplate()->template.'" data-phone-template="'.$app->system->getDefaultPhoneTemplate()->template.'" value="'.$phone.'" /></div>
          </div>
        ';
        
    }else{
        return '
          <input type="text" name="'.$params["input_name"].'" class="form-control phoneMask" placeholder="'.$app->system->getPhoneTemplate()->template.'" data-phone-template="'.$app->system->getPhoneTemplate()->template.'" value="'.$phone.'" />
        ';
    }

}

public function outInputRegistration(){
    global $app;

    if($app->settings->registration_authorization_method == "email-phone"){
        return '
        <input type="text" class="form-control" placeholder="'.translate("tr_6d583882982109ecefdc7c553d3fdef7").'" name="registration_login">
        <label class="form-label-error" data-name="registration_login" ></label>
        ';
    }

    if($app->settings->registration_authorization_method == "email"){
        return '
        <input type="text" class="form-control" placeholder="'.translate("tr_92d65fa726a6a4b889597e2e0b1efa58").'" name="registration_login">
        <label class="form-label-error" data-name="registration_login" ></label>
        ';
    }
       
    if($app->settings->registration_authorization_method == "phone"){

        if($app->system->multiPhonesStatus()){

            $phones = $app->system->getPhones();
            if($phones){
                foreach ($phones as $key => $value) {
                    $items .= '<span data-code="+'.$value->code.'" data-format="'.$value->template.'" data-icon="'.$app->storage->name($value->icon)->host(true)->get().'" ><img src="'.$app->storage->name($value->icon)->host(true)->get().'" /> '.$value->country.' +'.$value->code.'</span>';
                }
            }

            return '
              <div class="input-phone-countries-container" >
                  <div class="input-phone-countries-items" > <span class="input-phone-countries-change-item" ><img src="'.$app->storage->name($app->system->getDefaultPhoneTemplate()->icon)->host(true)->get().'" /> +'.$app->system->getDefaultPhoneTemplate()->code.'</span> <div class="input-phone-countries-items-container" >'.$items.'</div> </div>
                  <div class="input-phone-countries" ><input type="text" name="registration_login" class="form-control phoneMask" placeholder="'.$app->system->getDefaultPhoneTemplate()->template.'" data-phone-template="'.$app->system->getDefaultPhoneTemplate()->template.'" /></div>
              </div>
              <label class="form-label-error" data-name="registration_login" ></label>
            ';
        }else{
            return '
              <input type="text" name="registration_login" class="form-control phoneMask" placeholder="'.$app->system->getPhoneTemplate()->template.'" data-phone-template="'.$app->system->getPhoneTemplate()->template.'" />
              <label class="form-label-error" data-name="registration_login" ></label>
            ';
        }

    }

}

public function tpl($name=null){
    $this->tpl = $name;
    return $this;
}

public function wrapperInfo($code=null, $params=[]){
    global $app;

    if($code == "dashboard-improv"){

        $title = "";
        $subtitle = "";
        $image = "";

        if($params){

            if($params["search"]){
                return '
                <div class="wrapper-image-no-data" >
                    <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
                    <h3>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h3>
                    <p>'.translate("tr_2ddad39a6fc8e396dca6763bd2d4b93d").'</p>
                </div>
                ';
            }elseif($params["filter"]){
                return '
                <div class="wrapper-image-no-data" >
                    <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
                    <h3>'.translate("tr_8767f9ec282489d3e8e29021d0967187").'</h3>
                    <p>'.translate("tr_5bc04afa29bed6d07675bb927f5cbfb4").'</p>
                </div>
                ';
            }else{
               if($params["title"]){
                    $title = '<h3>'.$params["title"].'</h3>';
               }
               if($params["subtitle"] != null){
                   if($params["subtitle"]){
                        $subtitle = '<p>'.$params["subtitle"].'</p>';
                   }else{
                        $subtitle = '<p>'.translate("tr_cd49d589a08b40c4c940a29bad33f428").'</p>';
                   }
               }
            }
            
            if($params["image"]){
                $image = '<img src="'.$app->storage->getAssetImage($params["image"]).'" />';
            }else{
                $image = '<img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />';
            }

            if($title){
                return '
                <div class="wrapper-image-no-data" >
                    '.$image.'
                    '.$title.'
                    '.$subtitle.'
                </div>
                '; 

            }

        }
       
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
            <h3>'.translate("tr_26254ca95ba8d208a1674e9b23653d50").'</h3>
        </div>
        ';

    }elseif($code == "dashboard-no-widgets-home"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <h3>'.translate("tr_e052f09496f4671e700f93c6a53b6e0d").'</h3>
            <p>'.translate("tr_3223e20841238c07151e26d7601bf5ee").'</p>
            <button class="mt-4 btn btn-label-primary waves-effect waves-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCustomizeTemplate" >'.translate("tr_d1b8c2f66dabcb50cc87beb285a63659").'</button>
        </div>
        ';            
    }elseif($code == "dashboard-no-users"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('5098379222216956.png').'" />
            <p>'.translate("tr_eb25bc736f9de4c4d6832c941e5fd76e").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-no-data"){
        return '
        <div class="wrapper-alert-no-data" >

          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-info-circle ti-xs"></i>
            </span>
            '.translate("tr_26254ca95ba8d208a1674e9b23653d50").'
          </div>

        </div>
        ';            
    }elseif($code == "dashboard-no-data-image"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('0020193778848547.webp').'" />
            <h3>'.translate("tr_26254ca95ba8d208a1674e9b23653d50").'</h3>
        </div>
        ';            
    }elseif($code == "dashboard-change-section"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <p>'.translate("tr_fb2183560e84158e9cc2879b51e219c1").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-change-language"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4521109394024985.webp').'" />
            <p>'.translate("tr_42ed03f75e89b142f2b8b46ad6436579").'</p>
        </div>
        ';            
    }elseif($code == "dashboard-no-access-widget"){
        return '
        <div class="wrapper-alert-no-data" >

          <div class="alert alert-primary d-flex align-items-center" role="alert">
            <span class="alert-icon text-primary me-2">
              <i class="ti ti-info-circle ti-xs"></i>
            </span>
            '.translate("tr_561a7b922485b20da2c7df36a801fe01").'
          </div>

        </div>
        ';            
    }elseif($code == "dashboard-access-is-closed"){
        return '
        <div class="wrapper-image-no-data" >
            <img src="'.$app->storage->getAssetImage('4812111112558029.webp').'" />
            <h3>'.translate("tr_d898fe8c5596b396e4a5e2459083a06a").'</h3>
            <p>'.translate("tr_b4db9c359643a68d5e0056ac910d163d").'</p>
        </div>
        ';            
    }

}



 }