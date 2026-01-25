public function integrationsTestSms(){

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($this->settings->contact_phone){
        $result = $this->addons->sms($_POST["integration_sms_service"])->test($_POST);
        return json_answer(["status"=>true, "answer"=>_json_encode($result["answer"])]);
    }else{
        return json_answer(["status"=>false, "type_show"=>"notice", "type_answer"=>"warning", "answer"=>translate("tr_5b9518c48bfd1493d19f21bbc499fa80")]);
    }

}