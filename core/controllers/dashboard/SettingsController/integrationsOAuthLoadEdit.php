public function integrationsOAuthLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->oauth($_POST["id"])->fieldsForm()]);

}