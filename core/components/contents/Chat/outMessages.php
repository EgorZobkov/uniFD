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