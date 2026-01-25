public function allChatMessages()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/chat.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $this->view->setParamsComponent(["data"=>(object)$data, "breadcrumbs"=>["chain"=>[translate("tr_c52b4c5cbc879d56c633f568acfbf205")=>$this->router->getRoute("dashboard-chat"), translate("tr_8805c192ba830efc195acc12cdceacf0")=>null]]]);

    return $this->view->preload('chat/all-messages', ["data"=>(object)$data, "title"=>translate("tr_8805c192ba830efc195acc12cdceacf0")]);

}