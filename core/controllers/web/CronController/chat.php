public function chat(){

    $responders = $this->model->chat_responders->sort("id asc")->getAll("status=?", [0]);

    if($responders){

        $users = $this->model->users->getAll("status=?", [1]);

        foreach ($responders as $key => $value) {

            if(!$value["time_send"] || $this->datetime->currentTime() >= strtotime($value["time_send"])){

                $this->model->chat_responders->update(["status"=>1], $value["id"]);

                foreach (_json_decode($value["channels"]) as $channel_id) {
                    
                    $getChannel = $this->model->chat_channels->find("id=?", [$channel_id]);

                    if($getChannel){

                        if($getChannel->type == "support"){

                            if($users){
                                foreach ($users as $user) { 
                                    
                                    $this->component->chat->sendMessage(["from_user_id"=>0,"whom_user_id"=>$user["id"], "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);
                                    $this->notify->sendMessageFirebase(["token"=>$user["firebase_token"], "title"=>$getChannel->name, "text"=>$value["text"], "screen"=>"dialogue", "channel_id"=>$channel_id]);

                                }
                            }

                        }elseif($getChannel->type == "closed"){

                            $this->component->chat->sendMessage(["from_user_id"=>0, "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);

                            if($users){
                                foreach ($users as $user) { 
                                    
                                    if(!$this->component->chat->checkChannelDisableNotify($channel_id, $user["id"])){
                                        $this->notify->sendMessageFirebase(["token"=>$user["firebase_token"], "title"=>$getChannel->name, "text"=>$value["text"], "screen"=>"dialogue", "channel_id"=>$channel_id]);
                                    }

                                }
                            }

                        }else{

                            $this->component->chat->sendMessage(["from_user_id"=>0, "channel_id"=>$channel_id, "text"=>$value["text"], "attach_files"=>$value["image"] ? [$value["image"]] : null, "responder_id"=>$value["id"]]);

                        }

                    }

                }

            }

        }
    }
    

}