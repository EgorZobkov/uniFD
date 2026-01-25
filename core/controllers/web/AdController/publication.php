public function publication(){ 

    $answer = [];
    $admin = false;

    if($this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){
        $admin = true;
    }

    $answer = $this->component->ads->validationFormCreate($_POST);

    if(empty($answer)){

        if($this->system->checkingBadRequests("ad_create", $this->user->data->id)){
            return json_answer(["status"=>false]);
        }

        if(!$this->user->isAuth()){

            $this->session->set("ad-create-save", $_POST);
            return json_answer(["auth"=>false]); 

        }else{

            if(!$this->component->profile->checkVerificationPermissions($this->user->data->id, "create_ad")){
                return json_answer(["verification"=>false]);
            }
            
        }

        $result = $this->component->ads->publication($_POST,$this->user->data->id,$admin);

        return json_answer(["status"=>true, "route"=>$this->component->ads->detectRoute($result)]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}