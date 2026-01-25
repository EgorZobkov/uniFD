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