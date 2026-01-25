public function verificationSend()
{   

    $answer = [];

    if(!$this->user->data->phone){
        $answer[] = translate("tr_d817ba992bb0e66e0cc7d881cc20b3d7");
    }

    if(!$this->user->data->email){
        $answer[] = translate("tr_a23bf8ca60fd96fbbe314a0f57607ed7");
    }

    if(!$_POST["attach_files"]){
        $answer[] = translate("tr_c1ceac7d2dceaa0c7a340ba970f44e10");
    }

    if(empty($answer)){

        $_POST["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);

        $this->model->users_verifications->insert(["time_create"=>$this->datetime->getDate(), "user_id"=>$this->user->data->id, "media"=>_json_encode($_POST["attach_files"]), "status"=>"awaiting_verification", "uniq_code"=>$this->session->get("user-verification-code")]);

        $this->event->sendUserVerification(["user_id"=>$this->user->data->id]);

        return json_answer(["status"=>true]);
    }else{
        return json_answer(["status"=>false, "answer"=>implode("\n", $answer)]);
    }

}