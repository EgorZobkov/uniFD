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