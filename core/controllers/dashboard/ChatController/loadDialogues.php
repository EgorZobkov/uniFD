public function loadDialogues()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->component->chat->outDialoguesDashboard(0, 1)]);

}