public function loadDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['token']){
        $getDialogue = $this->model->chat_dialogues->find("token=?", [$_POST['token']]);
        $getChannel = $this->model->chat_channels->find("id=?", [$getDialogue->channel_id]);       
        return json_answer(["content"=>$this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard($getDialogue->id ?: 0,$getChannel->id), true)]);     
    }else{
        return json_answer(["content"=>$this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard(0,$_POST['channel_id']), true)]);
    }

}