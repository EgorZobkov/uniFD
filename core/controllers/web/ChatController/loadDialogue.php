public function loadDialogue()
{   

    $params["from_user_id"] = $this->user->data->id;
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    $data = $this->component->chat->getDialogue($params);

    if($data){

        if(!$params["channel_id"]){
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue.tpl')]);
        }else{
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue-channel.tpl')]);
        }

    }

}