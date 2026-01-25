public function checkVerifyContact(){

    if($_POST["email"] && $this->settings->email_confirmation_status){

        if($this->validation->isEmail($_POST["email"])->status == true){
            if($this->user->data->email != $_POST["email"]){

                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$_POST["email"], $this->user->data->id])){
                    return json_answer(["status"=>true]);
                }

            }
        }

    }elseif($this->clean->phone($_POST["phone"]) && $this->settings->phone_confirmation_status){

        if($this->validation->isPhone($_POST["phone"])->status == true){
            if($this->user->data->phone != $this->clean->phone($_POST["phone"])){

                if(!$this->model->users_verified_contacts->find("contact=? and user_id=?", [$this->clean->phone($_POST["phone"]), $this->user->data->id])){
                    return json_answer(["status"=>true]);
                }
  
            }
        }

    }

    return json_answer(["status"=>false]);
    
}