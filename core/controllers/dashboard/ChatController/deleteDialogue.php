public function deleteDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->chat->deleteFullDialogue(0, $_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}