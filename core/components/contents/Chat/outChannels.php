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