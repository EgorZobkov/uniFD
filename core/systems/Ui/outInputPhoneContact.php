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