public function dialogue($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/chat.js\" type=\"module\" ></script>"]);

    $getDialogue = $this->model->chat_dialogues->find("id=?", [$id]);

    if(!$getDialogue){
       $this->router->goToRoute("dashboard-chat");
    }

    $getChannel = $this->model->chat_channels->find("id=?", [$getDialogue->channel_id]);

    $data["from_user_id"] = $getDialogue->from_user_id;
    $data["user"] = $this->model->users->findById($getDialogue->from_user_id);
    $data["dialogue_id"] = $getDialogue->id;
    $data["channel_id"] = $getDialogue->channel_id;
    $data["token"] = $getDialogue->token;
    $data["dialogue"] = $this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard($getDialogue->id,$getChannel->id), true);

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_c52b4c5cbc879d56c633f568acfbf205")=>$this->router->getRoute("dashboard-chat"), translateFieldReplace($getChannel, "name")=>$this->router->getRoute("dashboard-chat-channel", [$getDialogue->channel_id])]]]);

    $this->view->setParamsPreload(["id"=>$id]);

    return $this->view->preload('chat/dialogue', ["data"=>(object)$data, "title"=>translateFieldReplace($getChannel, "name")]);

}