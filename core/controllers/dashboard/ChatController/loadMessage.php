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