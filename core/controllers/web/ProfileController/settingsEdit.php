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