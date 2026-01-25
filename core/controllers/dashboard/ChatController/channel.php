public function channel($id)
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/chat.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->channel = $this->model->chat_channels->find("id=?", [$id]);

    if(!$data->channel){
        $this->router->goToRoute("dashboard-chat");
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_c52b4c5cbc879d56c633f568acfbf205")=>$this->router->getRoute("dashboard-chat"), translateFieldReplace($data->channel, "name")=>null]]]);

    $this->view->setParamsPreload(["id"=>$id]);

    if($data->channel->type == "support"){

        $data->dialogues = $this->component->chat->outDialoguesDashboard(0, $data->channel->id);
        
        return $this->view->preload('chat/dialogues', ["data"=>(object)$data, "title"=>$data->channel->name]);

    }else{

        $data->dialogue = $this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard(0,$id), true);

        return $this->view->preload('chat/channel', ["data"=>(object)$data, "title"=>$data->channel->name]);

    }

}