public function checkCodeVerifyContact(){

    if($this->system->checkVerifyContact(["email"=>$_POST['email'], "phone"=>$_POST['phone']], $_POST['code'])){
        $this->model->users_verified_contacts->insert(["user_id"=>$this->user->data->id,"contact"=>$_POST['email'] ?: $_POST['phone']]);
        return json_answer(["status"=>true]);
    }else{
        return json_answer(["status"=>false, "answer"=>translate("tr_97084b0ab2cc806ea55a7ea61f5b8ff9")]);
    }
    
}