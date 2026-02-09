public function showContacts(){  

    $contacts_items = "";
    $ad_contact = $this->session->get("ad-contact");

    if(!$ad_contact[$_POST["id"]]){
        return;
    }

    $data = $this->component->ads->getAd($_POST["id"]);

    if($data->status != 1 || $data->block_forever_status){
         return;
    }

    $contact_name = ($data->contacts->name ?? null) ?: $data->user->name;

    $visibility = $this->model->users_contacts_visibility->find("user_id=?", [$data->user_id]);
    $showPhone = $visibility && $visibility->show_phone;
    $showEmail = $visibility && $visibility->show_email;
    $showTelegram = $visibility && $visibility->show_telegram;
    $showVk = $visibility && $visibility->show_vk;

    $phone = $visibility ? ($visibility->phone ?: $data->user->phone) : ($data->user->phone ?? '');
    $email = $visibility ? ($visibility->email ?: $data->user->email) : ($data->user->email ?? '');

    if($data){

        if($showPhone && $phone){
                if($this->settings->phone_add_plus_status){
                    $phone = "+" . trim($phone, "+");
                }
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="tel:'.$phone.'" target="_blank" >
                        <img src="'.$this->storage->name("9aa2c959051f186bf1f74435227f2a1a.webp")->path('images')->get().'" />
                        '.$phone.'
                    </a>
                ';
            }

            if($showEmail && $email){
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="mailto:'.$email.'" target="_blank" >
                        <img src="'.$this->storage->name("ad4223f1837394992a75515fb489a3e4.webp")->path('images')->get().'" />
                        '.$email.'
                    </a>
                ';
            }

            $telegram = $visibility ? $visibility->telegram : ($data->user->contacts->telegram ?? '');
            $vk = $visibility ? $visibility->vk : null;

            if($showTelegram && $telegram){
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="https://t.me/'.htmlspecialchars($telegram).'" target="_blank" >
                        <img src="'.$this->storage->name("social/tg.png")->path('images')->get().'" />
                        Telegram
                    </a>
                ';
            }

            if($showVk && $vk){
                $vkLink = (strpos($vk, 'http') === 0) ? $vk : 'https://vk.com/'.ltrim($vk, '/');
                $contacts_items .= '
                    <a class="card-contact-user-item-box" href="'.htmlspecialchars($vkLink).'" target="_blank" >
                        <img src="'.$this->storage->name("social/vk.png")->path('images')->get().'" />
                        ВКонтакте
                    </a>
                ';
            }

            $content = '
            <div class="card-contact-user" >

                <div class="card-contact-user-item" >
                <p>'.translate("tr_d38d6d925c80a2267031f3f03d0a9070").'</p>
                <h4>'.$contact_name.'</h4>
                </div>

                <div class="card-contact-user-item" >
                    <p>'.translate("tr_75768c49c24662cc4465237b0731e1ce").'</p>

                    '.$contacts_items.'

                </div>

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