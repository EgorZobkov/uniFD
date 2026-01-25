public function updateCountMessages()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["count"=>$this->component->chat->countMessagesDashboard(), "dialogues"=>$this->component->chat->outDialoguesDashboard(0, 1), "data"=>$this->component->chat->getIdsDialoguesAndCountMessagesDashboard()]);

}