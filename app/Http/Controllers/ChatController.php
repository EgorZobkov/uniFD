<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers;

 use App\Systems\Controller;

 class ChatController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function channelDisableNotify()
{   

    $result = $this->component->chat->channelDisableNotify($_POST['id'], $this->user->data->id);

    if($result){
        return json_answer(["status"=>true, "answer"=>translate("tr_01c876d00ece03bb17a12c3bf56cbed8"), "label"=>translate("tr_d31197c4fee0b3f97578d4fa41be8939")]);
    }else{
        return json_answer(["status"=>true, "answer"=>translate("tr_82117011f27f10617684a4386eeb248d"), "label"=>translate("tr_d155d300b3d5e139185b987e1962fd87")]);
    }

}

public function deleteDialogue()
{   

    $this->component->chat->deleteDialogue($this->user->data->id, $_POST['id']);

    return json_answer(["status"=>true]);

}

public function deleteMessage()
{   

    $this->component->chat->deleteMessage($this->user->data->id, $_POST['id']);

    return json_answer(["status"=>true]);

}

public function loadDialogue()
{   

    $params["from_user_id"] = $this->user->data->id;
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    $data = $this->component->chat->getDialogue($params);

    if($data){

        if(!$params["channel_id"]){
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue.tpl')]);
        }else{
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue-channel.tpl')]);
        }

    }

}

public function loadDialogues()
{   

    $data["channels"] = $this->component->chat->getChannels($this->user->data->id);
    $data["dialogues"] = $this->component->chat->getDialogues($this->user->data->id);

    return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogues.tpl')]);

}

public function loadMessages()
{   

    $params["from_user_id"] = $this->user->data->id;
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    $data = $this->component->chat->getDialogue($params);

    if($data){

        if(!$params["channel_id"]){ 
            return json_answer(["content"=>$this->component->chat->outMessages($data)]);
        }else{ 
            return json_answer(["content"=>$this->component->chat->outMessagesChannel($data)]);
        }

    }

}

public function openSendMessage()
{   

    $params = $_POST['params'] ? _json_decode(urldecode($_POST['params'])) : [];
    
    if($this->component->chat->verifyIntegrityParams($params)){

        $params["from_user_id"] = $this->user->data->id;
        $params["token"] = $this->component->chat->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"]]);

        $data = $this->component->chat->getDialogue($params);

        if($data){
            return json_answer(["content"=>$this->view->setParamsComponent(['data'=>(object)$data])->includeComponent('profile/chat/dialogue.tpl')]);
        }

    }

}

public function send()
{   

    $params["from_user_id"] = $this->user->data->id;
    $params["text"] = $_POST['text'];
    $params["token"] = $_POST['token'];
    $params["channel_id"] = $_POST['channel_id'];

    if($this->system->checkingBadRequests("chat",$this->user->data->id)){
        return json_answer(["status"=>false]);
    }

    if($_POST['attach_files']){
        $params["attach_files"] = $this->storage->uploadAttachFiles($_POST['attach_files'], $this->config->storage->users->attached);
    }

    $id = $this->component->chat->sendMessage($params);

    return json_answer(["id"=>$id]); 

}

public function sendRequestReview()
{   

    $this->component->chat->sendAction("user_asks_review", ["from_user_id"=>$this->user->data->id, "dialogue_id"=>$_POST['dialogue_id']]);
    return json_answer(["status"=>true, "answer"=>translate("tr_1d352cc4cf47d86f6773d891190c9640")]);

}

public function updateCountMessages()
{   

    return json_answer($this->component->chat->updateCountMessages($this->user->data->id));

}

public function uploadAttach()
{   

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