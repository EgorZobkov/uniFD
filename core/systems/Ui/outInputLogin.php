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