public function openSendMessage()
{   

    $params = $_POST['params'] ? _json_decode(urldecode($_POST['params'])) : [];
    
    if($this->component->chat->verifyIntegrityParams($params)){

        $params["from_user_id"] = $this->user->data->id;
        $params["token"] = $this->component->chat->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"]]);

        $data = $this->component->chat->getDialogue($params);

        if($data){
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue.tpl')]);
        }

    }

}