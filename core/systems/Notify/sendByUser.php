public function sendByUser(){
    global $app;

    if(isset($this->code) && isset($this->userId)){

        $this->params["chat_id"] = $this->user->messenger_token_id;

        if($this->user->notifications_method == "email"){
            $this->sendEmail();
        }elseif($this->user->notifications_method == "telegram"){
            if($this->user->messenger_token_id){
                $this->sendMessenger("telegram");
            }else{
                $this->sendEmail();
            }
        }

    }

    $this->params(null);
    $this->code(null);
    $this->userId(null);
    $this->to(null);

}