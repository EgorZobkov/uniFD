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