<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class ChatController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_channels->insert(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "type"=>$_POST['type'], "status"=>(int)$_POST['status']]);

        return json_answer(["status"=>true, "type_answer"=>"success", "type_show"=>"notice", "answer"=>code_answer("add_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function addResponder()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $time_send = $this->datetime->getDate();

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['send'] == "date"){
        if($this->validation->requiredField($_POST['date'])->status == false){
            $answer['date'] = $this->validation->error;
        }else{
            $time_send = $this->datetime->format("Y-m-d H:i:s")->convert($_POST['date']);
            if($time_send < $this->datetime->getDate()){
                $answer['date'] = translate("tr_822c6c202c2e953029ad54b4f87cdf9f");
            }
        }
    }

    if($this->validation->requiredFieldArray($_POST['channels'])->status == false){
        $answer['channels'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_responders->insert(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "send"=>$_POST['send'], "time_send"=>$time_send, "channels"=>_json_encode($_POST['channels']), "from_user_id"=>$this->user->data->id]);

        $this->session->setNotifyDashboard("success", code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function addToBlacklist()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $result = $this->component->profile->addToBlacklist(0, $_POST['id'], $_POST['channel_id']);

    if($result){
        return json_answer(["answer"=>translate("tr_dc322d08f2015f6b63d17cb7b8b15d3e"), "label"=>translate("tr_e3d48147853bb99996169256b5eb7cb9")]);
    }else{
        return json_answer(["answer"=>translate("tr_a58a5c103be003b8a1a58e101a0e45ca"), "label"=>translate("tr_35903deefce1704c3623df8a08d9880f")]);
    }

}

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

public function deleteBlacklist()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->users_blacklist->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->chat_channels->delete("id=?", [$_POST['id']]);
    $this->model->chat_messages->delete("channel_id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->chat->deleteFullDialogue(0, $_POST['id']);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

public function deleteMessage()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->component->chat->deleteMessage(0, $_POST['id']);

    return json_answer(["status"=>true]);

}

public function deleteResponder()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $this->model->chat_responders->delete("id=?", [$_POST['id']]);

    $this->session->setNotifyDashboard("success", code_answer("delete_successfully"));

    return json_answer(["status"=>true]);

}

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

public function editAutomessages()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST["actions"]){
        if(is_array($_POST["actions"])){
            foreach ($_POST["actions"] as $id => $value) {
                $this->model->chat_automessages->update(["text"=>$value], $id);
            }
        }
    }
    
    $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

    return json_answer(["status"=>true]);

}

public function editChannel()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_channels->update(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "status"=>(int)$_POST['status']], $_POST['id']);

        $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function editResponder()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];
    $time_send = $this->datetime->getDate();

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($_POST['send'] == "date"){
        if($this->validation->requiredField($_POST['date'])->status == false){
            $answer['date'] = $this->validation->error;
        }else{
            $time_send = $this->datetime->format("Y-m-d H:i:s")->convert($_POST['date']);
            if($time_send < $this->datetime->getDate()){
                $answer['date'] = "tr_822c6c202c2e953029ad54b4f87cdf9f";
            }
        }
    }

    if($this->validation->requiredFieldArray($_POST['channels'])->status == false){
        $answer['channels'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['text'])->status == false){
        $answer['text'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->chat_responders->update(["name"=>$_POST['name'], "text"=>$_POST['text'], "image"=>$_POST["manager_image"] ?: null, "send"=>$_POST['send'], "time_send"=>$time_send, "channels"=>_json_encode($_POST['channels'])], $_POST['id']);

        $this->session->setNotifyDashboard("success", code_answer("save_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}

public function loadDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST['token']){
        $getDialogue = $this->model->chat_dialogues->find("token=?", [$_POST['token']]);
        $getChannel = $this->model->chat_channels->find("id=?", [$getDialogue->channel_id]);       
        return json_answer(["content"=>$this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard($getDialogue->id ?: 0,$getChannel->id), true)]);     
    }else{
        return json_answer(["content"=>$this->component->chat->outMessagesChannel($this->component->chat->getDialogueDashboard(0,$_POST['channel_id']), true)]);
    }

}

public function loadDialogues()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["content"=>$this->component->chat->outDialoguesDashboard(0, 1)]);

}

public function loadEditChannel()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->chat_channels->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('chat/load-edit-channel.tpl')]);

}

public function loadEditResponder()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->chat_responders->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('chat/load-edit-responder.tpl')]);

}

public function loadMessage()
{   

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $text = '';
    $media_items = '';

    $message = $this->model->chat_messages->find("id=?", [$_POST["id"]]);

    if($message){

        if($message->text){
            $text = decrypt($message->text);
        }

        if($message->media){
            foreach (_json_decode($message->media) as $key => $media_item) {
                $media_items .= '<a class="chat-dialogue-item-message-text-attach-image uniMediaSliderItem" href="'.$this->storage->name($media_item)->host(true)->get().'" data-media-key="'.$key.'" data-media-type="image" ><img src="'.$this->storage->name($media_item)->host(true)->get().'" /></a>';
            }
            $text .= '<div class="chat-dialogue-item-message-text-attach-list uniMediaSliderContainer" >'.$media_items.'</div>';
        }

    }

    return json_answer(['content'=>$this->view->setParamsComponent(['text'=>$text])->includeComponent('chat/load-message.tpl')]);
       
}

public function loadSupportDialogue()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $getDialogue = $this->model->chat_dialogues->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$getDialogue])->includeComponent('chat/canvas-dialogue.tpl')]);

}

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

public function send()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $params["from_user_id"] = 0;
    $params["text"] = $_POST['text'];
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    if($_POST['attach_files']){
        $params["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
    }

    $id = $this->component->chat->sendMessage($params);

    return json_answer(["id"=>$id]);

}

public function updateCountMessages()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    return json_answer(["count"=>$this->component->chat->countMessagesDashboard(), "dialogues"=>$this->component->chat->outDialoguesDashboard(0, 1), "data"=>$this->component->chat->getIdsDialoguesAndCountMessagesDashboard()]);

}

public function uploadAttach()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $result = '';

    $resultUpload = $this->storage->files($_FILES['attach_files'])->path('temp')->extList('images')->deleteOriginal(true)->use("resize")->upload();

    if($resultUpload){

        $result = '
          <div class="uni-attach-files-item-delete uniAttachFilesDeleteItem" ><i class="ti ti-x"></i></div>
          <img class="image-autofocus" src="'.$this->storage->name($resultUpload["name"])->path('temp')->get().'" />
          <input type="hidden" name="attach_files[]" value="'.$resultUpload["name"].'" >
        ';

    }

    return json_answer(["content"=>$result]);
       
}



 }