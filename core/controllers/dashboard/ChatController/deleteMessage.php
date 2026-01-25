public function deleteMessage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->chat->deleteMessage(0, $_POST['id']);

    return json_answer(["status"=>true]);

}