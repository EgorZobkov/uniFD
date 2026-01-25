public function update(){ 

    $answer = [];
    $admin = false;

    if(!$this->user->isAdminAuthAndCheckAccess("control", "dashboard-ads")->status){

        if(!$this->user->verificationAuth()){
            return json_answer(["auth"=>false, "route"=>outRoute("auth")]);
        }else{
            $data = $this->component->ads->getAd($_POST["ad_id"], $this->user->data->id);
        }

    }else{
        $admin = true;
        $data = $this->component->ads->getAd($_POST["ad_id"]);
    }

    $answer = $this->component->ads->validationFormCreate($_POST);

    if(empty($answer)){

        $result = $this->component->ads->update($_POST,$data->user_id,$_POST["ad_id"],$admin);

        return json_answer(["status"=>true, "route"=>$this->component->ads->buildAliasesAdCard($result->data)]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}