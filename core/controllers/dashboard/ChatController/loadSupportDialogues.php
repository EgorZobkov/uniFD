public function loadSupportDialogues()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content = '<div class="chat-dialogues-container" >';
    $content .= $this->component->chat->outDialoguesDashboard(0, 1);
    $content .= '</div>';

    return json_answer(["content"=>$content]);

}