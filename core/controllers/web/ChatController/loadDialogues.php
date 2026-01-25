public function loadDialogues()
{   

    $data["channels"] = $this->component->chat->getChannels($this->user->data->id);
    $data["dialogues"] = $this->component->chat->getDialogues($this->user->data->id);

    return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogues.tpl')]);

}