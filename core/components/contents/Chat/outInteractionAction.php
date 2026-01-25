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