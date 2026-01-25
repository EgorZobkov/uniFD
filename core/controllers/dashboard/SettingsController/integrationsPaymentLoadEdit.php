public function integrationsPaymentLoadEdit(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->addons->payment($_POST["id"])->fieldsForm()]);

}