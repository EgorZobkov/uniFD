public function integrationsSmsLoadOptions(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->sms($_POST["id"])->fieldsForm()]);

}