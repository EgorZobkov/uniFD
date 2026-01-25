<?php

/**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Components;

class Chat
{

 public $alias = "chat";

 public function actionsCode(){   
    global $app;

    $result["system_registration"] = ["code"=>"system_registration", "name"=>translate("tr_2fbd8719f2595bbe4fc24646e945e9a5"), "default_text"=>translate("tr_42dcb0688bf81f577abae9a24a5c89cc")];
    $result["system_create_order"] = ["code"=>"system_create_order", "name"=>translate("tr_bae21bd72d8b2119fde3b9a06e3fadd1"), "default_text"=>translate("tr_93c26db2cc5b20535a12240a84a54bbc")];
    $result["system_warning_contacts"] = ["code"=>"system_warning_contacts", "name"=>translate("tr_e483ec82aa15284772779570af27b6b4"), "default_text"=>translate("tr_fb8cbb9f7f9efe014cf480fc5e6581a3")];
    $result["add_to_favorite"] = ["code"=>"add_to_favorite", "name"=>translate("tr_133f79ab2178eac922b6e2f377b3bd31"), "default_text"=>translate("tr_133f79ab2178eac922b6e2f377b3bd31")];
    $result["view_ad_contacts"] = ["code"=>"view_ad_contacts", "name"=>translate("tr_0fdcc5b1907dca97842c2adac32220d7"), "default_text"=>translate("tr_0fdcc5b1907dca97842c2adac32220d7")];
    $result["user_asks_review"] = ["code"=>"user_asks_review", "name"=>translate("tr_3dafc7a392224b5c39c7026e97a48163"), "default_text"=>translate("tr_3dafc7a392224b5c39c7026e97a48163")];
    $result["new_review"] = ["code"=>"new_review", "name"=>translate("tr_86c5c722d85c935e52516e94507b72fc"), "default_text"=>translate("tr_86c5c722d85c935e52516e94507b72fc")];
    $result["response_review"] = ["code"=>"response_review", "name"=>translate("tr_7f2734e6e2c00ae3d7fc03b0086ad448"), "default_text"=>translate("tr_7f2734e6e2c00ae3d7fc03b0086ad448")];
    $result["first_message_support"] = ["code"=>"first_message_support", "name"=>translate("tr_1c57fd7cbed543999891bff2ac6fae08"), "default_text"=>translate("tr_2608c63813ff1c37252597c1e9c3882a")];

    return $result;

}

public function buildParams($params=[]){
    global $app;

    if($params["ad_id"]){
        $build["ad_id"] = $params["ad_id"];
    }

    if($params["channel_id"]){
        $build["channel_id"] = $params["channel_id"];
    }

    if($params["whom_user_id"]){
        $build["whom_user_id"] = $params["whom_user_id"];
    }

    $build["token"] = md5(implode(".", $build).'.'.$app->config->app->signature_hash);

    return urlencode(_json_encode($build));

}

public function buildToken($params=[]){

    if($params["ad_id"]){
        $build[] = $params["ad_id"];
    }

    if($params["channel_id"]){
        $build[] = $params["channel_id"];
    }

    $build[] = $params["from_user_id"] ?: 0;

    $build[] = $params["whom_user_id"] ?: 0;

    return md5(implode(".", $build));

}

public function channelDisableNotify($channel_id=0, $user_id=0){
    global $app;

    $getChannel = $app->model->chat_channels->find("id=?", [$channel_id]);

    if($getChannel->type != "support"){

        $get = $app->model->chat_channels_disable_notify->find("user_id=? and channel_id=?", [$user_id, $channel_id]);

        if($get){

            $app->model->chat_channels_disable_notify->delete("id=?", [$get->id]);

            return false;

        }else{

            $app->model->chat_channels_disable_notify->insert(["user_id"=>$user_id, "channel_id"=>$channel_id]);

            return true;

        }

    }

}

public function checkChannelDisableNotify($channel_id=0, $user_id=0){
    global $app;

    if($app->model->chat_channels_disable_notify->find("user_id=? and channel_id=?", [$user_id, $channel_id])){
        return true;
    }else{
        return false;
    }

}

public function countMessages($user_id=0, $dialogue_id=0, $channel_id=0){
     global $app;

     $count = 0;

     if($dialogue_id){
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and dialogue_id=?", [$user_id,$user_id,0,0,$dialogue_id]);
     }elseif($channel_id){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$channel_id,1]);

        if($getChannel->type == "support"){
            $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [$user_id,$user_id,0,0,$channel_id]);
        }else{ 
            if($getChannel){
                $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$getChannel->id,$user_id]);
                if(!$getView){
                    $count = $count + $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$getChannel->id,$user_id,0]);
                }else{
                    $count = $count + $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$getChannel->id,$getView->message_id,$user_id,0]);
                }
            }
        }

     }else{

        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=?", [$user_id,$user_id,0,0]);

        $getChannels = $app->model->chat_channels->getAll("type!=? and status=?", ["support",1]);
        if($getChannels){
            foreach ($getChannels as $value) {

                if(!$this->checkChannelDisableNotify($value["id"], $user_id)){

                    $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$value["id"],$user_id]);
                    if(!$getView){
                        $count = $count + $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$value["id"],$user_id,0]);
                    }else{
                        $count = $count + $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$value["id"],$getView->message_id,$user_id,0]);
                    }

                }

            }
        }

     }

     return $count;

}

public function countMessagesDashboard($channel_id=0){
     global $app;

     if($channel_id){
         return $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,$channel_id]);
     }else{
         return $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,1]);
     }

}

public function createDialogue($params=[], $only_my_dialog=false){
    global $app;

    $date = $app->datetime->getDate();
    $from_dialogue_id = 0;
    $whom_dialogue_id = 0;
    $from_token = '';
    $whom_token = '';

    $hash_id = md5(time().uniqid());

    if($params["channel_id"]){

        if(!$params["action"] && !$params["responder_id"]){

            $from_token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "channel_id"=>$params["channel_id"]]);

            $getFromDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$from_token]);

            if(!$getFromDialogue){
                $from_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["from_user_id"], "from_user_id"=>$params["whom_user_id"],"time_create"=>$date,"time_update"=>$date,"channel_id"=>(int)$params["channel_id"],"hash_id"=>$hash_id, "token"=>$from_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getFromDialogue->id);
                $hash_id = $getFromDialogue->hash_id;
            }
        }

        if(!$only_my_dialog){

            $whom_token = $this->buildToken(["from_user_id"=>$params["whom_user_id"], "whom_user_id"=>$params["from_user_id"], "channel_id"=>$params["channel_id"]]);

            $getWhomDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["whom_user_id"],$whom_token]);

            if(!$getWhomDialogue){
                $whom_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["whom_user_id"], "from_user_id"=>$params["from_user_id"],"time_create"=>$date,"time_update"=>$date,"channel_id"=>(int)$params["channel_id"],"hash_id"=>$hash_id, "token"=>$whom_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getWhomDialogue->id);
                $hash_id = $getWhomDialogue->hash_id;
            }

        }

    }else{

        if(!$params["action"]){

            $from_token = $this->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"]]);

            $getFromDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$from_token]);

            if(!$getFromDialogue){
                $from_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["from_user_id"], "from_user_id"=>$params["whom_user_id"],"time_create"=>$date,"time_update"=>$date,"ad_id"=>(int)$params["ad_id"],"hash_id"=>$hash_id, "token"=>$from_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getFromDialogue->id);
                $hash_id = $getFromDialogue->hash_id;
            }

        }

        if(!$only_my_dialog){

            $whom_token = $this->buildToken(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["whom_user_id"], "whom_user_id"=>$params["from_user_id"]]);

            $getWhomDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["whom_user_id"],$whom_token]);

            if(!$getWhomDialogue){
                $whom_dialogue_id = $app->model->chat_dialogues->insert(["user_id"=>$params["whom_user_id"], "from_user_id"=>$params["from_user_id"],"time_create"=>$date,"time_update"=>$date,"ad_id"=>(int)$params["ad_id"],"hash_id"=>$hash_id, "token"=>$whom_token]);
            }else{
                $app->model->chat_dialogues->update(["time_update"=>$date], $getWhomDialogue->id);
                $hash_id = $getWhomDialogue->hash_id;
            }

        }

    }

    return (object)["from_dialogue_id"=>$from_dialogue_id ?: $getFromDialogue->id, "whom_dialogue_id"=>$whom_dialogue_id ?: $getWhomDialogue->id, "hash_id"=>$hash_id, "from_token"=>$from_token, "whom_token"=>$whom_token];

}

public function createDialogueAndMessage($params=[], $event=true){
    global $app;

    if(!$params["from_user_id"] && !$params["whom_user_id"]){
        return;
    }

    if($params["ad_id"]){
        if(!$app->model->ads_data->find("id=?", [$params["ad_id"]])){
            return;
        }
    }

    if($app->component->profile->isBlacklistСross($params["whom_user_id"], $params["from_user_id"], $params["channel_id"])){
        return;
    }

    $date = $app->datetime->getDate();

    $dialogues = $this->createDialogue(["ad_id"=>(int)$params["ad_id"], "from_user_id"=>(int)$params["from_user_id"], "whom_user_id"=>(int)$params["whom_user_id"], "channel_id"=>(int)$params["channel_id"], "responder_id"=>(int)$params["responder_id"], "action"=>$params["action"]]);

    if(!$params["action"] && !$params["responder_id"]){
        $insert_id = $app->model->chat_messages->insert(["user_id"=>(int)$params["from_user_id"], "from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>(int)$params["whom_user_id"],"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"ad_id"=>(int)$params["ad_id"],"dialogue_id"=>$dialogues->from_dialogue_id,"hash_id"=>$dialogues->hash_id,"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$dialogues->from_token]);
    }

    $app->model->chat_messages->insert(["user_id"=>(int)$params["whom_user_id"], "from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>(int)$params["whom_user_id"],"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"ad_id"=>(int)$params["ad_id"],"dialogue_id"=>$dialogues->whom_dialogue_id,"hash_id"=>$dialogues->hash_id, "action"=>$params["action"],"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$dialogues->whom_token, "parent_message_id"=>$insert_id?:0]);

    if($event){
        $app->event->sendMessageChat($params);
    }

    return $insert_id;

}

public function deleteDialogue($user_id=0, $dialogue_id=0){
    global $app;

    $app->model->chat_dialogues->delete("user_id=? and id=?", [$user_id,$dialogue_id]);
    $app->model->chat_messages->delete("user_id=? and dialogue_id=?", [$user_id,$dialogue_id]);

}

public function deleteFullDialogue($user_id=0, $dialogue_id=0){
    global $app;

    $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [$user_id,$dialogue_id]);

    $app->model->chat_dialogues->delete("user_id=? and hash_id=?", [$user_id, $getDialogue->hash_id]);
    $app->model->chat_messages->delete("hash_id=? and action is null", [$getDialogue->hash_id]);

}

public function deleteMessage($user_id=0, $message_id=0){
     global $app;

     if($user_id){
        $getMessage = $app->model->chat_messages->find("from_user_id=? and id=?", [$user_id, $message_id]);
     }else{
        $getMessage = $app->model->chat_messages->find("id=?", [$message_id]);
     }

     if($getMessage){
        if($getMessage->channel_id){
            $app->model->chat_messages->delete("id=?", [$message_id]);
            $app->model->chat_messages->delete("parent_message_id=?", [$message_id]);
            $app->storage->clearAttachFiles(_json_decode($getMessage->media));
        }else{
            $app->model->chat_messages->update(["delete_status"=>1], $message_id);
            $app->model->chat_messages->update(["delete_status"=>1], ["parent_message_id=?", [$message_id]]);
        }
     }

}

public function getActionCode($name=null){
    global $app;

    $actionsCode = $this->actionsCode();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}

public function getChannels($user_id=0){
    global $app;

    $channels = [];

    $getChannels = $app->model->chat_channels->getAll("status=?", [1]);

    if($getChannels){
        foreach ($getChannels as $key => $value) {

            if($value["type"] == "support"){
                $lastMessage = $app->model->chat_messages->sort("id desc")->find('user_id=? and channel_id=? and delete_status=?', [$user_id,$value["id"],0]);
            }else{
                $lastMessage = $app->model->chat_messages->sort("id desc")->find('channel_id=? and delete_status=?', [$value["id"],0]);
            }
           
            $channels[] = arrayToObject(["item"=>$value, "last_message"=>$lastMessage ?: []]);

        }
    }

    return $channels;
    
}

public function getDialogue($params=[], $only_new_messages = false){
    global $app;

    $date = $app->datetime->getDate();

    $messages = [];
    $ad = [];
    $user = [];
    $getMessages = [];

    if($params["token"]){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);

        if(!$getDialogue){
            $this->createDialogue($params, true);
            $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);
        }

        if($getDialogue->ad_id){
            $ad = $app->component->ads->getAd($getDialogue->ad_id);
        }

        $user = $app->model->users->findById($getDialogue->from_user_id);

        if($only_new_messages){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and dialogue_id=? and status=? and from_user_id!=? and delete_status=?", [$params["from_user_id"],$getDialogue->id,0,$params["from_user_id"],0]);
        }else{
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and dialogue_id=? and delete_status=?", [$params["from_user_id"],$getDialogue->id,0]);
        }

        $lastMessage = $app->model->chat_messages->sort("id desc")->find('hash_id=? and delete_status=?', [$getDialogue->hash_id,0]);

        if($params["from_user_id"] != $lastMessage->from_user_id){
            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=?", [$getDialogue->hash_id]]);
        }

    }elseif($params["channel_id"]){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$params["channel_id"], 1]);

        if(!$getChannel){
            return [];
        }

        if($getChannel->type == "support"){

            $getDialogue = $app->model->chat_dialogues->find("user_id=? and channel_id=?", [$params["from_user_id"],$getChannel->id]);

            if($only_new_messages){
                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and channel_id=? and status=? and from_user_id!=? and delete_status=?", [$params["from_user_id"],$getChannel->id,0,$params["from_user_id"],0]);
            }else{
                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("user_id=? and channel_id=? and delete_status=?", [$params["from_user_id"],$getChannel->id,0]);
            }

            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=? and (user_id=? or whom_user_id=?)", [$getDialogue->hash_id, $params["from_user_id"], $params["from_user_id"]]]);            

        }elseif($getChannel->type == "closed" || $getChannel->type == "public"){

            if($only_new_messages){

                $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$getChannel->id,$params["from_user_id"]]);
                if($getView){
                    $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=? and from_user_id!=? and delete_status=? and id > ? and delete_status=?", [$getChannel->id,$params["from_user_id"], 0, $getView->message_id, 0]);
                }

            }else{

                $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=? and delete_status=?", [$getChannel->id,0]);

            }

            $lastMessage = $app->model->chat_messages->sort("id desc")->find('channel_id=?', [$getChannel->id]);

            if($lastMessage){
                if(!$app->model->chat_channels_view->find("channel_id=? and message_id=? and user_id=?", [$getChannel->id,$lastMessage->id,$params["from_user_id"]])){
                    $app->model->chat_channels_view->insert(["channel_id"=>$getChannel->id, "message_id"=>$lastMessage->id, "user_id"=>$params["from_user_id"]]);
                }
            }

        }

    }

    if($getMessages){

        $reverse = array_reverse($getMessages, true);

        foreach ($reverse as $key => $value) {

            $messages[$app->datetime->format("d.m.Y")->getDate($value["time_create"])][] = $value;

        }

    }

    return (object)["messages"=>$messages, "ad"=>$ad, "user"=>$user, "channel"=>$getChannel ? $getChannel : [], "token"=>$params["token"] ?: "", "dialogue"=>$getDialogue ?: []];     
}

public function getDialogueDashboard($dialogue_id=0, $channel_id=0){
    global $app;

    $date = $app->datetime->getDate();

    $messages = [];

    $getChannel = $app->model->chat_channels->find("id=?", [$channel_id]);

    if($getChannel){

        if($getChannel->type == "support"){

            $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [0,$dialogue_id]);

            $app->model->chat_messages->update(["time_view"=>$date, "status"=>1], ["hash_id=? and (user_id=? or whom_user_id=?)", [$getDialogue->hash_id, $getDialogue->user_id, $getDialogue->user_id]]);

            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("dialogue_id=? and channel_id=?", [$dialogue_id,$channel_id]);

        }elseif($getChannel->type == "closed"){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=?", [$channel_id]);
        }elseif($getChannel->type == "public"){
            $getMessages = $app->model->chat_messages->sort("id desc")->getAll("channel_id=?", [$channel_id]);
        }

        if($getMessages){

            $reverse = array_reverse($getMessages, true);

            foreach ($reverse as $key => $value) {

                $messages[$app->datetime->format("d.m.Y")->getDate($value["time_create"])][] = $value;

            }

        }

    }

    return (object)["messages"=>$messages, "channel"=>$getChannel ?: [], "dialogue"=>$getDialogue ?: [], "token"=>$getDialogue ? $getDialogue->token : ""];     

}

public function getDialogues($user_id=0, $channel_id=0){
    global $app;

    $dialogues = [];
    $ad = [];

    $getDialogues = $app->model->chat_dialogues->pagination(true)->page($_GET['page'] ? $_GET['page'] : $_POST['page'])->output(100)->search($_GET['search'] ? $_GET['search'] : $_POST['search'])->sort("time_update desc")->getAll("user_id=? and channel_id=?", [$user_id, $channel_id]);

    if($getDialogues){
        foreach ($getDialogues as $key => $value) {

            $ad = [];

            $lastMessage = $app->model->chat_messages->sort("id desc")->find('dialogue_id=? and delete_status=?', [$value["id"],0]);

            if($value["ad_id"]){

                $ad = $app->component->ads->getAd($value["ad_id"]);
                $user = $app->model->users->findById($value["from_user_id"]);

                $dialogues[] = arrayToObject(["item"=>$value, "ad"=>$ad, "user"=>$user, "last_message"=>$lastMessage ?: []]);

            }else{

                $user = $app->model->users->findById($value["from_user_id"]);

                $dialogues[] = arrayToObject(["item"=>$value, "ad"=>$ad, "user"=>$user, "last_message"=>$lastMessage ?: []]);

            }
           
        }
    }        

    return $dialogues;
    
}

public function getIdsDialoguesAndCountMessagesDashboard(){
    global $app;

    $result = [];

    $data = $app->model->chat_messages->getAll("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,1]);

    if($data){
        foreach ($data as $key => $value) {
            $result["support"][$value["token"]] = ["token"=>$value["token"], "dialogue_id"=>$value["dialogue_id"], "count"=>$app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=? and token=?", [0,0,0,0,1,$value["token"]])];
        }
    }

    $data = $app->model->chat_messages->getAll("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id!=? and channel_id!=?", [0,0,0,0,1,0]);

    if($data){
        foreach ($data as $key => $value) {
            $result["channel"][$value["channel_id"]] = ["channel_id"=>$value["channel_id"], "count"=>$app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and channel_id=?", [0,0,0,0,$value["channel_id"]])];
        }
    }

    return $result;

}

public function getWaitingRespondersDashboard(){
    global $app;

    return $app->model->chat_responders->count("status=?", [0]);

}

public function hasContactInformationInMessage($text=null){
    global $app;

    if($text){

          if(preg_match('/([A-Za-z0-9_\-]+\.)*[A-Za-z0-9_\-]+@([A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9]\.)+[A-Za-z]{2,4}/u',$text)){
              return true;
          }

          foreach ($app->config->phone_codes as $phone) {
              if(strpos($text, "+".$phone->code) !== false){
                  return true;
              }
          }

          foreach ($app->config->domain_zones as $zone) {
              if(strpos($text, $zone) !== false){
                  return true;
              }
          }

          if(strpos($text, "://") !== false || strpos($text, "www.") !== false || strpos($text, "http") !== false){
              return true;
          }

    }

    return false;

}

public function outChannels($channels=[]){
    global $app;

    foreach ($channels as $value) {

        $last_message = '';
        $count_message = '';

        $getCountMessage = $this->countMessages($app->user->data->id,0,$value->item->id);

        if($getCountMessage){
            if(!$this->checkChannelDisableNotify($value->item->id, $app->user->data->id)){
                $count_message = '<span class="chat-dialogues-item-content-count-messages" >'.$getCountMessage.'</span>';
            }else{
                $count_message = '<span class="chat-dialogues-item-content-count-messages label-color-secondary" >'.$getCountMessage.'</span>';
            }
        }

        if($value->last_message){
            if($value->last_message->text){
                $last_message = '<div class="chat-dialogues-item-content-message" >'.trimStr(decrypt($value->last_message->text), 60, true).$count_message.'</div>';
            }else{
                $last_message = '<div class="chat-dialogues-item-content-message" >'.translate("tr_5a34e5446905d8389a6dc403bdb76b72").$count_message.'</div>';
            }
        }

        ?>

        <div class="chat-dialogues-item actionOpenChannel" data-id="<?php echo $value->item->id; ?>" >

            <div class="chat-dialogues-item-avatar" >
                <img src="<?php echo $app->storage->name($value->item->image)->path(null)->host(true)->get(); ?>" class="image-autofocus" />
            </div>      
            <div class="chat-dialogues-item-content" >
                <div class="chat-dialogues-item-content-channel" >
                    <?php echo translateFieldReplace($value->item, "name"); ?>
                    <p><?php echo !$last_message ? translateFieldReplace($value->item, "text") : $last_message; ?></p>
                </div>
            </div>

        </div>

        <?php

    }

}

public function outChannelsDashboard($id=0){
     global $app;

     $channels = $app->model->chat_channels->getAll();

     if($channels){
        foreach ($channels as $value) {

            if(compareValues($id, $value["id"])){
                ?>
                  <a class="chat-sidebar-list-item active" href="<?php echo $app->router->getRoute("dashboard-chat-channel", [$value["id"]]); ?>" >
                    <div class="chat-sidebar-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
                    <div class="chat-sidebar-list-item-name" ><?php echo translateFieldReplace($value, "name"); ?></div>
                  </a>
                <?php
            }else{
                ?>
                  <a class="chat-sidebar-list-item" href="<?php echo $app->router->getRoute("dashboard-chat-channel", [$value["id"]]); ?>" >
                    <div class="chat-sidebar-list-item-image" > <img src="<?php echo $app->storage->name($value["image"])->get(); ?>" class="image-autofocus" > </div>
                    <div class="chat-sidebar-list-item-name" ><?php echo translateFieldReplace($value, "name"); ?></div>
                  </a>
                <?php
            }

        }
     }

}

public function outChannelsOptionsDashboard($ids=[]){
     global $app;

     $channels = $app->model->chat_channels->sort("id desc")->getAll("status=?", [1]);

     if($channels){
        foreach ($channels as $value) {

            if(compareValues($ids, $value["id"])){
                ?>
                <option value="<?php echo $value["id"]; ?>" selected="" ><?php echo $value["name"]; ?></option>
                <?php
            }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo $value["name"]; ?></option>
                <?php
            }

        }
     }

}

public function outDialogues($dialogues=[]){
    global $app;

    foreach ($dialogues as $value) {

        $last_message = '';
        $count_message = '';
        $view_status = '';

        $getCountMessage = $this->countMessages($app->user->data->id, $value->item->id);

        if($getCountMessage){
            $count_message = '<span class="chat-dialogues-item-content-count-messages" >'.$getCountMessage.'</span>';
        }

        if($value->last_message){

            if(!$value->last_message->action){
                if($value->last_message->text){
                    $last_message = '<div class="chat-dialogues-item-content-message" >'.trimStr(decrypt($value->last_message->text), 60, true).$count_message.'</div>';
                }else{
                    $last_message = '<div class="chat-dialogues-item-content-message" >'.translate("tr_5a34e5446905d8389a6dc403bdb76b72").$count_message.'</div>';
                }
            }else{
                $last_message = '<div class="chat-dialogues-item-content-message" >'.trimStr($this->outMessageAction($value->last_message->action, decrypt($value->last_message->text)), 60, true).$count_message.'</div>';
            }

            if($app->user->data->id == $value->last_message->from_user_id){

                if($value->last_message->status){
                    $view_status = '<span class="chat-dialogues-item-view-status" ><i class="ti ti-checks"></i></span>';
                }else{
                    $view_status = '<span class="chat-dialogues-item-view-status" ><i class="ti ti-check"></i></span>';
                }

            }

        }else{
            $last_message = '<div class="chat-dialogues-item-content-message" >'.translate("tr_0c40ace71e3e79f03d6ddfad326729a2").'</div>';
        }

        if($value->ad){
            ?>

            <div class="chat-dialogues-item actionOpenDialogue" data-token="<?php echo $value->item->token; ?>" >

                <div class="chat-dialogues-item-avatar" >
                    <img src="<?php echo $value->ad->media->images->first; ?>" class="image-autofocus" />
                </div>      
                <div class="chat-dialogues-item-content" >
                    <div class="chat-dialogues-item-content-user" ><?php echo $value->user->name.' '.$value->user->surname; ?></div>
                    <div class="chat-dialogues-item-content-title" ><?php echo trimStr($value->ad->title, 50, true); ?></div>
                    <?php echo $last_message; ?>

                    <div class="chat-dialogues-item-date" >
                       <?php echo $view_status; ?>
                       <?php echo $app->datetime->outLastTime($value->item->time_update); ?>
                    </div>

                </div>

            </div>

            <?php
        }else{
            ?>

            <div class="chat-dialogues-item actionOpenDialogue" data-token="<?php echo $value->item->token; ?>" >

                <div class="chat-dialogues-item-avatar" >
                    <img src="<?php echo $app->storage->name($value->user->avatar)->path(null)->host(true)->get(); ?>" class="image-autofocus" />
                </div>      
                <div class="chat-dialogues-item-content" >
                    <div class="chat-dialogues-item-content-user" ><?php echo $value->user->name.' '.$value->user->surname; ?></div>
                    <?php echo $last_message; ?>

                    <div class="chat-dialogues-item-date" >
                       <?php echo $view_status; ?>
                       <?php echo $app->datetime->outLastTime($value->item->time_update); ?>
                    </div>
                    
                </div>

            </div>

            <?php                
        }

    }

}

public function outDialoguesDashboard($user_id=0, $channel_id=0){
    global $app;

    $date = $app->datetime->getDate();

    $messages = [];
    $result = '';

    $getDialogues = $this->getDialogues($user_id, $channel_id);

    if($getDialogues){

        foreach ($getDialogues as $value) {

            $last_message = '';
            $count_message = '';
            $view_status = '';

            $getCountMessage = $this->countMessages($user_id, $value->item->id);

            if($getCountMessage){
                $count_message = '<span class="chat-dialogues-item-content-count-messages" >'.$getCountMessage.'</span>';
            }

            if($value->last_message){

                if(!$value->last_message->action){
                    if($value->last_message->text){
                        $last_message = '<div class="chat-dialogues-item-content-message" >'.trimStr(decrypt($value->last_message->text), 60, true).$count_message.'</div>';
                    }else{
                        $last_message = '<div class="chat-dialogues-item-content-message" >'.translate("tr_5a34e5446905d8389a6dc403bdb76b72").$count_message.'</div>';
                    }
                }else{
                    $last_message = '<div class="chat-dialogues-item-content-message" >'.trimStr($this->outMessageAction($value->last_message->action, decrypt($value->last_message->text)), 60, true).$count_message.'</div>';
                }

                if($user_id == $value->last_message->from_user_id){

                    if($value->last_message->status){
                        $view_status = '<span class="chat-dialogues-item-view-status" ><i class="ti ti-checks"></i></span>';
                    }else{
                        $view_status = '<span class="chat-dialogues-item-view-status" ><i class="ti ti-check"></i></span>';
                    }

                }

            }else{
                $last_message = '<div class="chat-dialogues-item-content-message" >'.translate("tr_0c40ace71e3e79f03d6ddfad326729a2").'</div>';
            }

            $result .= '
            <a class="chat-dialogues-item" href="'.$app->router->getRoute("dashboard-chat-dialogue", [$value->item->id]).'" data-id="'.$value->item->id.'" >

                <div class="chat-dialogues-item-avatar" >
                    <img src="'.$app->storage->name($value->user->avatar)->host(true)->get().'" class="image-autofocus" />
                </div>      
                <div class="chat-dialogues-item-content" >
                    <div class="row" >
                        <div class="col-12" >
                            <div class="chat-dialogues-item-content-user" >'.$value->user->name.' '.$value->user->surname.'</div>
                            '.$last_message.'
                        </div>
                        <div class="col-12" >
                            <div class="chat-dialogues-item-date" >
                           '.$view_status.'
                           '.$app->datetime->outLastTime($value->item->time_update).' 
                           </div>                           
                        </div>
                    </div>
                </div>

            </a>
            ';

        }

        return $result;            

    }else{

        return $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_GET['search'], "title"=>translate("tr_968488faec375288c4e05f1f5b3e72e5"), "subtitle"=>translate("tr_958760d20e2143ce732cb655d9e6ddf7")]);

    }
 
}

public function outInteractionAction($action=null, $data=[]){
    global $app;

    if($action == "new_review"){

        if($data){
            return '
                <div class="message-action-interaction" >
                    <a class="btn-custom-mini button-color-scheme1" href="'.$app->router->getRoute("profile-reviews").'" >'.translate("tr_9db2758d97a1823c3e70c288283ca48f").'</a>
                    <a class="btn-custom-mini button-color-scheme1" href="'.$app->router->getRoute("review-add", [$data["from_user_id"]]).'?item_id='.$data["ad_id"].'" >'.translate("tr_c54353bc2ed98bf7cf2fe4662235b117").'</a>
                </div>
            ';
        }

    }elseif($action == "user_asks_review"){

        if($data){
            return '
                <div class="message-action-interaction" >
                    <a class="btn-custom-mini button-color-scheme1" href="'.$app->router->getRoute("review-add", [$data["from_user_id"]]).'?item_id='.$data["ad_id"].'" >'.translate("tr_c54353bc2ed98bf7cf2fe4662235b117").'</a>
                </div>
            ';
        }

    }elseif($action == "response_review"){

        if($data){
            return '
                <div class="message-action-interaction" >
                    <a class="btn-custom-mini button-color-scheme1" href="'.$app->router->getRoute("profile-reviews").'" >'.translate("tr_9db2758d97a1823c3e70c288283ca48f").'</a>
                </div>
            ';
        }

    }

}

public function outMessageAction($action=null, $text=null){

    return translateField($text);

}

public function outMessages($data=[]){
    global $app;

    $media_items = "";
    $media_container = "";
    $result = "";

    foreach ($data->messages as $date => $nested) {

        $result .= '
            <div class="chat-dialogue-item-date" >
                '.$date.'
            </div>
        ';

        foreach ($nested as $value) {

            $media_items = "";
            $media_container = "";

            if($value["media"]){
                foreach (_json_decode($value["media"]) as $key => $media_item) {
                    $media_items .= '<a class="chat-dialogue-item-message-text-attach-image uniMediaSliderItem" href="'.$app->storage->name($media_item)->host(true)->get().'" data-media-key="'.$key.'" data-media-type="image" ><img src="'.$app->storage->name($media_item)->host(true)->get().'" /></a>';
                }
                $media_container = '<div class="chat-dialogue-item-message-text-attach-list uniMediaSliderContainer" >'.$media_items.'</div>';
            }

            if($value["action"]){

                $result .= '
                    <div class="chat-dialogue-item-container item-message-system" >
                        <div class="chat-dialogue-item-message" >
                            <div class="chat-dialogue-item-message-text" >'.$this->outMessageAction($value["action"], decrypt($value["text"])).$this->outInteractionAction($value["action"], $value).'</div>
                            <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                        </div>
                    </div>
                ';

            }else{

                if($value["from_user_id"] == $app->user->data->id){
                    if(!$value["delete_status"]){
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-from" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-menu" >
                                        <div class="uni-dropdown">
                                          <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                          <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                                <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                          </div>               
                                        </div>
                                    </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';   
                    }                 
                }else{
                    if(!$value["delete_status"]){
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-whom" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-avatar" > <img src="'.$app->storage->name($data->user->avatar)->host(true)->get().'" class="image-autofocus" > </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';
                    }
                }

            }

        }

    }

    return $result;
 
}

public function outMessagesChannel($data=[], $dashboard=false){
    global $app;

    $media_items = "";
    $media_container = "";
    $result = "";

    foreach ($data->messages as $date => $nested) {

        $result .= '
            <div class="chat-dialogue-item-date" >
                '.$date.'
            </div>
        ';

        foreach ($nested as $value) {

            $media_items = "";
            $media_container = "";

            if($value["media"]){
                foreach (_json_decode($value["media"]) as $key => $media_item) {
                    $media_items .= '<a class="chat-dialogue-item-message-text-attach-image uniMediaSliderItem" href="'.$app->storage->name($media_item)->host(true)->get().'" data-media-key="'.$key.'" data-media-type="image" ><img src="'.$app->storage->name($media_item)->host(true)->get().'" data- /></a>';
                }
                $media_container = '<div class="chat-dialogue-item-message-text-attach-list uniMediaSliderContainer" >'.$media_items.'</div>';
            }

            if($data->channel->type == "support"){

                if($dashboard){

                    if($value["from_user_id"]){
                        $user = $app->model->users->findById($value["from_user_id"]);
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-whom" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-avatar" > <a href="'.$app->component->profile->linkUserCard($user->alias).'" title="'.$user->name.'" target="_blank" ><img src="'.$app->storage->name($user->avatar)->host(true)->get().'" class="image-autofocus" ></a> </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';
                    }else{
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-from" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-menu" >
                                        <div class="uni-dropdown">
                                          <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                          <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                                <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                          </div>               
                                        </div>
                                    </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';
                    }

                }else{

                    if($app->user->data->id == $value["from_user_id"]){
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-from" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-menu" >
                                        <div class="uni-dropdown">
                                          <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                          <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                                <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                          </div>               
                                        </div>
                                    </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';                 
                    }else{
                        $result .= '
                            <div class="chat-dialogue-item-container item-message-whom" >
                                <div class="chat-dialogue-item-message" >
                                    <div class="chat-dialogue-item-message-avatar" > <img src="'.$app->storage->name($data->channel->image)->host(true)->get().'" class="image-autofocus" > </div>
                                    <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                    <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                                </div>
                            </div>
                        ';
                    }

                }


            }else{

                $menu = '';
                $menu_item_blacklist = '';

                if($app->component->profile->isBlacklist(0, $value["from_user_id"])){
                    $menu_item_blacklist = '<span class="uni-dropdown-content-item actionChatAddUserToBlacklist" data-id="'.$value["from_user_id"].'" data-channel-id="'.$value["channel_id"].'" >'.translate("tr_e3d48147853bb99996169256b5eb7cb9").'</span>';
                }else{
                    $menu_item_blacklist = '<span class="uni-dropdown-content-item actionChatAddUserToBlacklist" data-id="'.$value["from_user_id"].'" data-channel-id="'.$value["channel_id"].'" >'.translate("tr_35903deefce1704c3623df8a08d9880f").'</span>';
                }

                if($value["from_user_id"]){

                    if($dashboard){
                        $menu = '
                            <div class="chat-dialogue-item-message-menu" >
                                <div class="uni-dropdown">
                                  <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                  <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                        <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                        '.$menu_item_blacklist.'
                                  </div>               
                                </div>
                            </div>
                        ';
                    }else{
                        $menu = '
                            <div class="chat-dialogue-item-message-menu" >
                                <div class="uni-dropdown">
                                  <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                  <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                        <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                  </div>               
                                </div>
                            </div>
                        ';
                    }

                    $user = $app->model->users->findById($value["from_user_id"]);

                    $result .= '
                        <div class="chat-dialogue-item-container item-message-from" >
                            <div class="chat-dialogue-item-message" >
                                '.$menu.'
                                <div class="chat-dialogue-item-message-avatar" > <a href="'.$app->component->profile->linkUserCard($user->alias).'" title="'.$user->name.'" target="_blank" ><img src="'.$app->storage->name($user->avatar)->host(true)->get().'" class="image-autofocus" ></a> </div>
                                <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                            </div>
                        </div>
                    ';    

                }else{

                    if($dashboard){
                        $menu = '
                            <div class="chat-dialogue-item-message-menu" >
                                <div class="uni-dropdown">
                                  <span class="uni-dropdown-name"> <div class="chat-dialogue-item-menu" ><i class="ti ti-dots"></i></div> </span>  
                                  <div class="uni-dropdown-content uni-dropdown-content-align-right uni-dropdown-content-position-bottom" >
                                        <span class="uni-dropdown-content-item actionChatDeleteMessage" data-id="'.$value["id"].'" >'.translate("tr_ed2bbfbc53d83d3ad81f7fd6485ac6e8").'</span>
                                  </div>               
                                </div>
                            </div>
                        ';
                    }

                    $result .= '
                        <div class="chat-dialogue-item-container item-message-from" >
                            <div class="chat-dialogue-item-message" >
                                '.$menu.'
                                <div class="chat-dialogue-item-message-avatar" > <img src="'.$app->storage->name($data->channel->image)->host(true)->get().'" class="image-autofocus" > </div>
                                <div class="chat-dialogue-item-message-text" >'.decrypt($value["text"]).$media_container.'</div>
                                <div class="chat-dialogue-item-message-date" >'.date("H:i", strtotime($value["time_create"])).'</div>       
                            </div>
                        </div>
                    ';                        

                }              

            }

        }

    }

    return $result;
 
}

public function outRespondersDashboard(){
     global $app;

     $responders = $app->model->chat_responders->sort("id desc")->getAll("status=?", [0]);

     if($responders){
        foreach ($responders as $value) {
            ?>
              <div class="chat-sidebar-list-item loadEditResponder" data-id="<?php echo $value["id"]; ?>" >
                <div class="chat-sidebar-list-item-status" > <i class="ti ti-clock-hour-3"></i> </div>
                <div class="chat-sidebar-list-item-name" >
                    <strong><?php echo $value["name"]; ?></strong>
                    <div>
                    <?php
                        if($value["send"] == "now"){
                           echo '<small>'.translate("tr_848a83b00a92e5664b4af49d35661a50").'</small>';
                        }else{
                           if($app->datetime->currentTime() >= strtotime($value["time_send"])){
                                echo '<small>'.translate("tr_848a83b00a92e5664b4af49d35661a50").'</small>';
                           }else{
                                echo '<small>'.translate("tr_c31513e639b7c5d1a31ac47f7212b7bd").' '.$app->datetime->outStringDiff(null,$value["time_send"]).'</small>';
                           }
                        }
                    ?>
                    </div>
                </div>
              </div>
            <?php
        }
     }

}

public function sendAction($action=null, $params=[], $event=true){
    global $app;

    $getAction = $app->model->chat_automessages->find("action=?",[$action]);

    if(!$getAction){
        return;
    }

    $text = translateField($getAction->text) ?: $this->getActionCode($action)->default_text;

    if($action == "user_asks_review"){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and id=?", [$params["from_user_id"],$params["dialogue_id"]]);

        if($getDialogue){

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$getDialogue->user_id,$getDialogue->from_user_id,$getDialogue->ad_id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"],"token"=>$getDialogue->token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "new_review"){

        $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "ad_id"=>$params["ad_id"]]);

        $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "ad_id"=>$params["ad_id"], "token"=>$token, "action"=>$action, "text"=>$text]);

    }elseif($action == "add_to_favorite"){

        $ad = $app->component->ads->getAd($params["ad_id"]);

        if($ad && !$ad->delete){

            if(!$ad->user->notifications['add_to_favorite']){
                return;
            }

            $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id]);

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$ad->user_id,$ad->id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id, "token"=>$token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "view_ad_contacts"){

        $ad = $app->component->ads->getAd($params["ad_id"]);

        if($ad && !$ad->delete){

            if(!$ad->user->notifications['view_ad_contacts']){
                return;
            }

            $token = $this->buildToken(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id]);

            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$ad->user_id,$ad->id,$action]);

            if(!$check){
                $this->sendMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$ad->user_id, "ad_id"=>$ad->id, "token"=>$token, "action"=>$action, "text"=>$text]);
            }

        }

    }elseif($action == "first_message_support"){

        if($params["whom_user_id"] == 0){
            $check = $app->model->chat_messages->find("user_id=? and from_user_id=?", [$params["from_user_id"], 0]);
            if(!$check){
                $this->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$params["from_user_id"], "text"=>$text, "channel_id"=>1, "attach_files"=>null, "action"=>$action], $event);
            }
        }

    }else{

        if($params["from_user_id"]){
            $check = $app->model->chat_messages->find("from_user_id=? and whom_user_id=? and ad_id=? and action=?", [$params["from_user_id"],$params["whom_user_id"],$params["ad_id"]?:0,$action]);
            if(!$check){
                $this->createDialogueAndMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$text, "attach_files"=>null, "ad_id"=>$params["ad_id"]?:0, "action"=>$action]);
            }
        }else{
            $this->createDialogueAndMessage(["from_user_id"=>0, "whom_user_id"=>$params["whom_user_id"], "text"=>$text, "channel_id"=>1, "attach_files"=>null, "action"=>$action], $event);
        }

    }

}

public function sendMessage($params=[]){
    global $app;

    $date = $app->datetime->getDate();
    $hash_id = md5(time().uniqid());
    $message_id = 0;

    if(!$params["action"]){
        if(trim($params["text"])){
            if(_mb_strlen($params["text"]) > 5000){
                $params["text"] = trimStr($params["text"], 5000);
            }
        }else{
            if(!$params["attach_files"]){
                return;
            }
        }
    }

    if($params["token"]){

        $getDialogue = $app->model->chat_dialogues->find("user_id=? and token=?", [$params["from_user_id"],$params["token"]]);

        if($getDialogue){

            $message_id = $this->createDialogueAndMessage(["ad_id"=>$getDialogue->ad_id, "from_user_id"=>$getDialogue->user_id, "whom_user_id"=>$getDialogue->from_user_id, "text"=>$params["text"], "channel_id"=>$getDialogue->channel_id, "attach_files"=>$params["attach_files"], "responder_id"=>$getDialogue->responder_id, "action"=>$params["action"]]);

        }else{

            if($params["action"]){
                $message_id = $this->createDialogueAndMessage(["ad_id"=>$params["ad_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$params["text"], "channel_id"=>$params["channel_id"]?:0, "attach_files"=>$params["attach_files"], "responder_id"=>$params["responder_id"]?:0, "action"=>$params["action"]]);
            }

        }

    }elseif($params["channel_id"]){

        $getChannel = $app->model->chat_channels->find("id=? and status=?", [$params["channel_id"], 1]);

        if($getChannel){

            if($getChannel->type == "support"){

                $message_id = $this->createDialogueAndMessage(["from_user_id"=>$params["from_user_id"], "whom_user_id"=>$params["whom_user_id"], "text"=>$params["text"], "channel_id"=>$params["channel_id"], "attach_files"=>$params["attach_files"], "responder_id"=>$params["responder_id"]]);
           
            }else{

                if($app->component->profile->isBlacklistСross($params["from_user_id"], 0, $params["channel_id"])){
                    return;
                }

                $message_id = $app->model->chat_messages->insert(["user_id"=>0,"from_user_id"=>(int)$params["from_user_id"],"whom_user_id"=>0,"text"=>$params["text"] ? encrypt($params["text"]) : null,"time_create"=>$date,"media"=>$params["attach_files"] ? _json_encode($params["attach_files"]) : null,"status"=>0,"channel_id"=>(int)$params["channel_id"],"responder_id"=>(int)$params["responder_id"],"has_contact_information"=>$this->hasContactInformationInMessage($params["text"]) ? 1 : 0, "token"=>$this->buildToken(["channel_id"=>$params["channel_id"], "from_user_id"=>$params["from_user_id"], "whom_user_id"=>0])]);

            }

        }

    }

    return $message_id;

}

public function updateCountMessages($user_id=0, $notification=false){
     global $app;

     $count = 0;
     $count_notify = 0;
     $count_in_channel = 0;
     $total_count_in_channel = 0;

     if($notification){
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=? and notification_status=?", [$user_id,$user_id,0,0,0]);
     }else{
        $count = $app->model->chat_messages->count("user_id=? and whom_user_id=? and status=? and delete_status=?", [$user_id,$user_id,0,0]);
     }

     $getChannels = $app->model->chat_channels->getAll("type!=? and status=?", ["support",1]);
     if($getChannels){
        foreach ($getChannels as $value) {

            $getView = $app->model->chat_channels_view->sort("id desc")->find("channel_id=? and user_id=?", [$value["id"],$user_id]);
            if(!$getView){
                if($notification){
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=? and notification_status=?", [$value["id"],$user_id,0,0]);
                }else{
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and from_user_id!=? and delete_status=?", [$value["id"],$user_id,0]);
                }
            }else{
                if($notification){
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=? and notification_status=?", [$value["id"],$getView->message_id,$user_id,0,0]);
                }else{
                    $count_in_channel = $app->model->chat_messages->count("channel_id=? and id > ? and from_user_id!=? and delete_status=?", [$value["id"],$getView->message_id,$user_id,0]);
                }
            }

            if(!$this->checkChannelDisableNotify($value["id"], $user_id)){
                $count_notify += $count_in_channel;
            }

            $total_count_in_channel += $count_in_channel;

        }
     }

     return ["count"=>$count+$total_count_in_channel, "notify"=>$count+$count_notify];

}

public function verifyIntegrityParams($params=[]){
    global $app;

    if($params){
        $token = $params["token"];
        unset($params["token"]);
        if($token == md5(implode(".", $params).'.'.$app->config->app->signature_hash)){
            return true;
        }
    }

    return false;

}



}