<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Http\Controllers\Api;

use App\Systems\Controller;

class ChatController extends Controller {

    public function __construct($app){
        parent::__construct($app); 
    }

    public function getDialogues(){   

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = [];
        $last_message = "";
        $status_last_message = null;

        $getChannels = $this->model->chat_channels->getAll("status=?", [1]);

        if($getChannels){
            foreach ($getChannels as $key => $value) {

                $last_message = "";

                $getCountMessage = $this->component->chat->countMessages($_GET['user_id'],0,$value["id"]);

                if($value["type"] == "support"){
                    $getLastMessage = $this->model->chat_messages->sort("id desc")->find('user_id=? and channel_id=? and delete_status=?', [$_GET['user_id'],$value["id"],0]);
                }else{
                    $getLastMessage = $this->model->chat_messages->sort("id desc")->find('channel_id=? and delete_status=?', [$value["id"],0]);
                }

                if($getLastMessage){

                    if(!$getLastMessage->action){
                        if($getLastMessage->text){
                            $last_message = trimStr(decrypt($getLastMessage->text), 60, true);
                        }else{
                            $last_message = translate("tr_5a34e5446905d8389a6dc403bdb76b72");
                        }
                    }else{
                        $last_message = trimStr($this->component->chat->outMessageAction($getLastMessage->action, decrypt($getLastMessage->text)), 60, true);
                    }

                }else{
                    $last_message = $value["text"];
                }

                $result[] = ["id"=>$value["id"], "name"=>$value["name"], "text"=>$last_message, "image"=>$this->storage->name($value["image"])->host(true)->get(), "type"=>$value["type"], "count_messages"=>$getCountMessage, "status_last_message"=>null, "view"=>"channel"];

            }
        }

        $getDialogues = $this->model->chat_dialogues->sort("time_update desc")->getAll("user_id=? and channel_id=?", [$_GET['user_id'], 0]);

        if($getDialogues){
            foreach ($getDialogues as $key => $value) {

                $ad = [];
                $last_message = "";
                $status_last_message = null;

                $getCountMessage = $this->component->chat->countMessages($_GET['user_id'], $value["id"]);

                $lastMessage = $this->model->chat_messages->sort("id desc")->find('dialogue_id=? and delete_status=?', [$value["id"],0]);

                if($lastMessage){

                    if(!$lastMessage->action){
                        if($lastMessage->text){
                            $last_message = trimStr(decrypt($lastMessage->text), 60, true);
                        }else{
                            $last_message = translate("tr_5a34e5446905d8389a6dc403bdb76b72");
                        }
                    }else{
                        $last_message = trimStr($this->component->chat->outMessageAction($lastMessage->action, decrypt($lastMessage->text)), 60, true);
                    }

                    if($_GET['user_id'] == $lastMessage->from_user_id){

                        $status_last_message = $lastMessage->status ? 1 : 0;

                    }

                }else{
                    $last_message = translate("tr_0c40ace71e3e79f03d6ddfad326729a2");
                }

                if($value["ad_id"]){

                    $ad = $this->component->ads->getAd($value["ad_id"]);
                    $user = $this->model->users->findById($value["from_user_id"]);

                    $result[] = ["token"=>$value["token"], "name"=>$this->user->name($user), "title"=>$ad->title, "text"=>$last_message, "image"=>$ad->media->images->first, "time_create"=>$this->datetime->outLastTime($value["time_update"]), "count_messages"=>$getCountMessage, "status_last_message"=>$status_last_message, "view"=>"ad"];

                }else{

                    $user = $this->model->users->findById($value["from_user_id"]);

                    $result[] = ["token"=>$value["token"], "name"=>$this->user->name($user), "text"=>$last_message, "image"=>$this->storage->name($user->avatar)->host(true)->get(), "time_create"=>$this->datetime->outLastTime($value["time_update"]), "count_messages"=>$getCountMessage, "status_last_message"=>$status_last_message, "view"=>"user"];

                }
               
            }
        }  

        $countMessages = $this->component->chat->countMessages($_GET['user_id']);
        $hashChanges = md5($countMessages . '-' . count($result));  

        return json_answer(["auth"=>true, "data"=>$result, "count_dialogues"=>count($result), "hash_changes"=>$hashChanges, "count_messages"=>$countMessages]);

    }    

    public function getCountMessages(){   

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        return json_answer(["auth"=>true, "data"=>$this->component->chat->countMessages($_GET['user_id'])]);

    } 

    public function clearDialogues(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->model->chat_dialogues->delete("user_id=?", [$_POST['user_id']]);
        $this->model->chat_messages->delete("user_id=? and dialogue_id=?", [$_POST['user_id'],0]);

        return json_answer(["status"=>true, "auth"=>true]);

    } 

    public function deleteMessage(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->component->chat->deleteMessage($_POST['user_id'], $_POST['id']);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function deleteDialogue(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->component->chat->deleteDialogue($_POST['user_id'], $_POST['id']);

        return json_answer(["status"=>true, "auth"=>true]);

    }

    public function getDialogue(){   

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $messages = [];
        $ad = [];

        $params["ad_id"] = (int)$_GET['ad_id'];
        $params["whom_user_id"] = (int)$_GET['whom_user_id'];
        $params["from_user_id"] = (int)$_GET['user_id'];
        $params["token"] = $_GET['dialogue_token'];
        $params["channel_id"] = (int)$_GET['channel_id'];

        $data = $this->component->chat->getDialogue($params);

        if($data){

            if(!$params["channel_id"]){

                if($data->messages){
                    $messages = $this->outMessages($data, $_GET['user_id']);
                }

                return json_answer(["auth"=>true, "data"=>$messages, "user"=>["id"=>$data->user->id, "avatar"=>$this->storage->name($data->user->avatar)->host(true)->get(), "name"=>$this->user->name($data->user), "label_activity"=>$this->user->labelActivity($data->user->time_last_activity)], "type"=>null, "disable_notify"=>$this->component->chat->checkChannelDisableNotify($data->channel->id, $_GET['user_id']) ? true : false, "ad"=>$data->ad ? ["id"=>$data->ad->id, "image"=>$data->ad->media->images->first, "title"=>$data->ad->title, "price"=>$this->api->price(["ad"=>$data->ad]), "status"=>(int)$data->ad->status, "status_name"=>$this->api->statusNameAd($data->ad->status)] : null, "blocked_send"=>$this->component->profile->isBlacklist($_GET['user_id'], $data->user->id) ? true : false, "blocked_user"=>$this->component->profile->isBlacklist($data->user->id, $_GET['user_id']) ? true : false, "count_messages"=>$this->component->chat->countMessages($_GET['user_id']), "dialogue_id"=>$data->dialogue->id]);

            }else{

                if($data->messages){
                    $messages = $this->outMessagesChannel($data, $_GET['user_id']);
                }

                return json_answer(["auth"=>true, "data"=>$messages, "user"=>["avatar"=>$this->storage->name($data->channel->image)->host(true)->get(), "name"=>translateFieldReplace($data->channel, "name", $_REQUEST["lang_iso"]), "text"=>translateFieldReplace($data->channel, "text", $_REQUEST["lang_iso"])], "type"=>$data->channel->type, "disable_notify"=>$this->component->chat->checkChannelDisableNotify($data->channel->id, $_GET['user_id']) ? true : false, "ad"=>null, "blocked_send"=>$this->component->profile->isBlacklist(0, $_GET['user_id'], $data->channel->id) ? true : false, "blocked_user"=>false, "count_messages"=>$this->component->chat->countMessages($_GET['user_id']), "dialogue_id"=>null]);

            }

        }

        return json_answer(["auth"=>true, "data"=>null, "count_messages"=>$this->component->chat->countMessages($_GET['user_id'])]);

    }

    public function updateDialogue(){   

        if(!$this->api->verificationAuth($_GET['token'], $_GET['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $messages = [];
        $data = [];

        $params["from_user_id"] = (int)$_GET['user_id'];
        $params["token"] = $_GET['dialogue_token'];
        $params["channel_id"] = (int)$_GET['channel_id'];

        $data = $this->component->chat->getDialogue($params, true);

        if(!$params["channel_id"]){
            if($data->messages){
                $messages = $this->outMessages($data, $_GET['user_id'], false);
            }
        }else{
            if($data->messages){
                $messages = $this->outMessagesChannel($data, $_GET['user_id'], false);
            }
        }

        return json_answer(["auth"=>true, "data"=>$messages ?: null, "label_activity"=>$this->user->labelActivity($data->user->time_last_activity) ?: null]);

    }

    public function outMessagesChannel($data=[], $user_id=0, $out_date=true){

        $media_items = [];
        $result = [];

        foreach ($data->messages as $date => $nested) {

            if($out_date){
                $result[] = ['date'=>$date, 'action'=>'date'];
            }else{
                if($date != $this->datetime->format("d.m.Y")->getDate()){
                    $result[] = ['date'=>$date, 'action'=>'date'];
                }
            }

            foreach ($nested as $value) {

                $media_items = [];

                if($value["media"]){
                    foreach (_json_decode($value["media"]) as $key => $media_item) {
                        $media_items[] = $this->storage->name($media_item)->host(true)->get();
                    }
                }

                $text = $value["text"] ? $this->api->encryptAES(decrypt($value["text"])) : null;

                if($data->channel->type == "support"){

                    if($user_id == $value["from_user_id"]){
                        $user = $this->model->users->findById($value["from_user_id"]);
                        $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'right', 'user'=>['id'=>$user->id, 'avatar'=>$this->storage->name($user->avatar)->host(true)->get(),'name'=>$this->user->name($user)], 'text'=>$text, 'date'=>date("H:i", strtotime($value["time_create"])), "menu"=>true];                
                    }else{
                        $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'left', 'user'=>['avatar'=>$this->storage->name($data->channel->image)->host(true)->get(),'name'=>$data->channel->name], 'text'=>$text, 'date'=>date("H:i", strtotime($value["time_create"])), "menu"=>false]; 
                    }


                }else{

                    if($value["from_user_id"]){
                        $user = $this->model->users->findById($value["from_user_id"]);
                        $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'right', 'user'=>['id'=>$user->id, 'avatar'=>$this->storage->name($user->avatar)->host(true)->get(),'name'=>$this->user->name($user)], 'text'=>$text, 'date'=>date("H:i",strtotime($value["time_create"])), "menu"=>false];
                    }else{
                        $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'right', 'user'=>['avatar'=>$this->storage->name($data->channel->image)->host(true)->get(),'name'=>$data->channel->name], 'text'=>$text, 'date'=>date("H:i", strtotime($value["time_create"])), "menu"=>false];
                    }              

                }

            }

        }

        return $result;
     
    }

    public function send(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $attach = [];

        $_POST['attach'] = $_POST["attach"] ? _json_decode(html_entity_decode($_POST["attach"])) : [];

        $params["from_user_id"] = $_POST['user_id'];
        $params["text"] = $this->api->decryptAES($_POST['text']);
        $params["token"] = $_POST['dialogue_token'];
        $params["channel_id"] = (int)$_POST['channel_id'];

        if($this->system->checkingBadRequests("chat",$_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        if($_POST['attach']){

            foreach ($_POST['attach'] as $key => $value) {
                $attach[] = $value["name"];
            }

           $params["attach_files"] = $this->storage->uploadAttachFiles($attach, $this->config->storage->users->attached);
        }

        $id = $this->component->chat->sendMessage($params);

        return json_answer(["auth"=>true, "id"=>$id]);

    }

    public function disableNotifications(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $result = $this->component->chat->channelDisableNotify((int)$_POST['id'], $_POST['user_id']);

        if($result){
            return json_answer(["status"=>true, "answer"=>translate("tr_01c876d00ece03bb17a12c3bf56cbed8")]);
        }else{
            return json_answer(["status"=>false, "answer"=>translate("tr_82117011f27f10617684a4386eeb248d")]);
        }

    }

    public function outMessages($data=[], $user_id=0, $out_date=true){

        $media_items = [];
        $result = [];

        foreach ($data->messages as $date => $nested) {

            if($out_date){
                $result[] = ['date'=>$date, 'action'=>'date'];
            }else{
                if($date != $this->datetime->format("d.m.Y")->getDate()){
                    $result[] = ['date'=>$date, 'action'=>'date'];
                }
            }

            foreach ($nested as $value) {

                $media_items = [];

                if($value["media"]){
                    foreach (_json_decode($value["media"]) as $key => $media_item) {
                        $media_items[] = $this->storage->name($media_item)->host(true)->get();
                    }
                }

                $text = $value["text"] ? $this->api->encryptAES(decrypt($value["text"])) : null;

                if($value["action"]){

                    $result[] = ['id'=>$value["id"], 'action'=>'action','attach'=>$media_items ?: null,'align'=>'left', 'text'=>$this->component->chat->outMessageAction($value["action"], $text),'interaction'=>$this->outInteractionAction($value["action"], $value) ?: null, 'date'=>date("H:i",strtotime($value["time_create"])), "menu"=>false];

                }else{

                    if($value["from_user_id"] == $user_id){
                        if(!$value["delete_status"]){

                            $user = $this->model->users->findById($value["from_user_id"]);
                            $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'right', 'user'=>['id'=>$user->id, 'avatar'=>$this->storage->name($user->avatar)->host(true)->get(),'name'=>$this->user->name($user)], 'text'=>$text, 'date'=>date("H:i", strtotime($value["time_create"])), "menu"=>true];   
   
                        }                 
                    }else{
                        if(!$value["delete_status"]){

                            $result[] = ['id'=>$value["id"], 'action'=>'message','attach'=>$media_items ?: null,'align'=>'left', 'user'=>['id'=>$data->user->id, 'avatar'=>$this->storage->name($data->user->avatar)->host(true)->get(),'name'=>$this->user->name($data->user)], 'text'=>$text, 'date'=>date("H:i", strtotime($value["time_create"])), "menu"=>false];

                        }
                    }

                }

            }

        }

        return $result;
     
    }

    public function outInteractionAction($action=null, $data=[]){
        global $app;

        $result = [];

        if($action == "new_review"){

            if($data){
                $result[] = [
                    "name"=>translate("tr_9db2758d97a1823c3e70c288283ca48f"),
                    "link"=>$app->router->getRoute("profile-reviews"),
                    "action"=>"profile_reviews",
                ];
                $result[] = [
                    "name"=>translate("tr_c54353bc2ed98bf7cf2fe4662235b117"),
                    "link"=>$app->router->getRoute("review-add", [$data["from_user_id"]]).'?item_id='.$data["ad_id"],
                    "item_id"=>$data["ad_id"],
                    "from_user_id"=>$data["from_user_id"],
                    "action"=>"new_review",
                ];
            }

        }elseif($action == "user_asks_review"){

            if($data){
                $result[] = [
                    "name"=>translate("tr_c54353bc2ed98bf7cf2fe4662235b117"),
                    "link"=>$app->router->getRoute("review-add", [$data["from_user_id"]]).'?item_id='.$data["ad_id"],
                    "item_id"=>$data["ad_id"],
                    "from_user_id"=>$data["from_user_id"],
                    "action"=>"user_asks_review",
                ];
            }

        }elseif($action == "response_review"){

            if($data){
                $result[] = [
                    "name"=>translate("tr_9db2758d97a1823c3e70c288283ca48f"),
                    "link"=>$app->router->getRoute("profile-reviews"),
                    "action"=>"profile_reviews",
                ];
            }

        }

        return $result;

    }

    public function sendRequestReview(){   

        if(!$this->api->verificationAuth($_POST['token'], $_POST['user_id'])){
            return json_answer(["auth"=>false]);
        }

        $this->component->chat->sendAction("user_asks_review", ["from_user_id"=>$_POST['user_id'], "dialogue_id"=>(int)$_POST['id']]);
        return json_answer(["status"=>true, "answer"=>translate("tr_1d352cc4cf47d86f6773d891190c9640")]);

    }

}
