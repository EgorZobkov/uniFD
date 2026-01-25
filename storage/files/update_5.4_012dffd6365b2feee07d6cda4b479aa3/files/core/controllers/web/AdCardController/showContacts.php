public function showContacts(){  

    $contacts_items = "";
    $messengers_items = "";
    $messengers = "";
    $ad_contact = $this->session->get("ad-contact");

    if(!$ad_contact[$_POST["id"]]){
        return;
    }

    $data = $this->component->ads->getAd($_POST["id"]);

    if($data->status != 1 || $data->block_forever_status){
         return;
    }

    $data->contacts->name = $data->contacts->name ?: $data->user->name;
    $data->contacts->phone = $data->contacts->phone ?: $data->user->phone;

    if($data){

        if($data->contact_method == "all" || $data->contact_method == "call"){

            if($data->contacts->phone){

                if($this->settings->phone_add_plus_status){
                    $data->contacts->phone = "+" . trim($data->contacts->phone, "+");
                }

                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="tel:'.$data->contacts->phone.'" target="_blank" >
                        <img src="'.$this->storage->name("9aa2c959051f186bf1f74435227f2a1a.webp")->path('images')->get().'" />
                        '.$data->contacts->phone.'
                    </a>
                ';
            }

            if($data->contacts->email && $this->settings->board_publication_required_email){
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="mailto:'.$data->contacts->email.'" target="_blank" >
                        <img src="'.$this->storage->name("ad4223f1837394992a75515fb489a3e4.webp")->path('images')->get().'" />
                        '.$data->contacts->email.'
                    </a>
                ';
            }

            if($data->contacts->max && $this->settings->board_publication_required_contact_max){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://max.ru/'.$data->contacts->max.'" target="_blank" >
                        <img src="'.$this->storage->name("social/max.png")->path('images')->get().'" />
                        Max
                    </a>
                ';
            }

            if($data->contacts->telegram && $this->settings->board_publication_required_contact_telegram){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://t.me/'.$data->contacts->telegram.'" target="_blank" >
                        <img src="'.$this->storage->name("social/tg.png")->path('images')->get().'" />
                        Telegram
                    </a>
                ';
            }

            if($data->contacts->whatsapp && $this->settings->board_publication_required_contact_whatsapp){
                $messengers_items .= '
                    <a class="card-contact-user-item-box" href="https://wa.me/'.$this->clean->phone($data->contacts->whatsapp).'" target="_blank" >
                        <img src="'.$this->storage->name("social/wa.png")->path('images')->get().'" />
                        WhatsApp
                    </a>
                ';
            }

            if($messengers_items){
                $messengers = '
                <div class="card-contact-user-item" >
                    <p>'.translate("tr_68c83fa9d2124c69367bcaae051a83dc").'</p>

                    '.$messengers_items.'

                </div>
                ';
            }

            $content = '
            <div class="card-contact-user" >

                <div class="card-contact-user-item" >
                <p>'.translate("tr_d38d6d925c80a2267031f3f03d0a9070").'</p>
                <h4>'.$data->contacts->name.'</h4>
                </div>

                <div class="card-contact-user-item" >
                    <p>'.translate("tr_75768c49c24662cc4465237b0731e1ce").'</p>

                    '.$contacts_items.'

                </div>

                '.$messengers.'

            </div>';

            if($this->settings->board_card_who_phone_view == "all"){

                if($this->user->isAuth()){
                    $this->event->showAdContacts(["ad_id"=>$_POST["id"], "from_user_id"=>$this->user->data->id]);
                }

                return json_answer(["content"=>$content]);

            }elseif($this->settings->board_card_who_phone_view == "auth"){

                if($this->user->isAuth()){

                    if($this->component->profile->checkVerificationPermissions($this->user->data->id, "view_contacts")){

                        $this->event->showAdContacts(["ad_id"=>$_POST["id"], "from_user_id"=>$this->user->data->id]);

                        return json_answer(["content"=>$content]);

                    }else{
                        return json_answer(["verification"=>false]);
                    }

                }else{
                    return json_answer(["auth"=>false]);
                }

            }

        }

    }

}