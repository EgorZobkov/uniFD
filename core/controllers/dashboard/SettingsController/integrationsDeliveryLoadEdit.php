public function integrationsDeliveryLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->delivery($_POST["id"])->fieldsForm()]);

}