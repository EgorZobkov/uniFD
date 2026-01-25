public function chat()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    $data->channels = $this->component->chat->getChannels($this->user->data->id);
    $data->dialogues = $this->component->chat->getDialogues($this->user->data->id);

    $data->dialogues = $this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogues.tpl');

    return $this->view->render('profile/chat', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c52b4c5cbc879d56c633f568acfbf205")]]);
}