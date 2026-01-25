public function main()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/chat.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->channel = $this->model->chat_channels->find("type=?", ["support"]);

    if(!$data->channel){
        abort(404);
    }

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_c52b4c5cbc879d56c633f568acfbf205")=>$this->router->getRoute("dashboard-chat")]]]);

    $data->dialogues = $this->component->chat->outDialoguesDashboard(0, $data->channel->id);
    
    return $this->view->preload('chat/dialogues', ["data"=>(object)$data, "title"=>translate("tr_c52b4c5cbc879d56c633f568acfbf205")]);

}