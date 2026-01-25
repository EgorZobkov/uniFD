public function goPartnerLink(){

    if($this->settings->board_card_who_transition_partner_link == "auth"){

        if(!$this->user->isAuth()){
            return json_answer(["auth"=>false]);
        }

    }

    $ad = $this->model->ads_data->find("id=?", [$_POST['id']]);

    if($ad){
        if($ad->partner_link){
            $this->event->goPartnerLink(["from_user_id"=>$this->user->data->id, "ad_id"=>$_POST['id']]);
            return json_answer(["link"=>$ad->partner_link]);
        }
    }
    
}