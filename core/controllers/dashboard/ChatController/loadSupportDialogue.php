public function loadSupportDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $getDialogue = $this->model->chat_dialogues->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$getDialogue])->includeComponent('chat/canvas-dialogue.tpl')]);

}