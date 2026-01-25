public function create($params=[]){
    global $app;

    if($params['order_id']){
        $order = $app->component->transaction->getDealItem($params['order_id']);
        if($order){

            if($order->from_user_id != $params['from_user_id'] && $order->whom_user_id != $params['from_user_id']){
                return false;
            }

            if($order->from_user_id == $params['from_user_id']){
                $params['whom_user_id'] = $order->whom_user_id;
            }else{
                $params['whom_user_id'] = $order->from_user_id;
            }

            $params['item_id'] = $order->item->item_id;

        }else{
            return false;
        }
    }elseif($params['whom_user_id']){

        $chat = $app->model->chat_messages->find("(action=? and from_user_id=? and whom_user_id=? and ad_id=?) or (action=? and from_user_id=? and whom_user_id=? and ad_id=?)", ["user_asks_review",$params['whom_user_id'],$params['from_user_id'],$params['item_id'],"new_review",$params['from_user_id'],$params['whom_user_id'],$params['item_id']]);
        
        if(!$chat){
            return false;
        }

    }else{
        return false;
    }

    $rating = 1;

    if($params['rating']){
        $rating = abs($params['rating']) <= 5 ? abs($params['rating']) : 5;
    }

    $attach_files = $app->storage->uploadAttachFiles($params['attach_files'], $app->config->storage->users->attached);

    $app->model->reviews->insert(["item_id"=>(int)$params['item_id'], "from_user_id"=>(int)$params['from_user_id'], "whom_user_id"=>(int)$params['whom_user_id'], "text"=>$params['text'], "rating"=>$rating, "media"=>$attach_files ? _json_encode($attach_files) : null,"time_create"=>$app->datetime->getDate(),"order_id"=>$params['order_id']?:null]);

    $app->event->createReview(["item_id"=>(int)$params['item_id'], "from_user_id"=>(int)$params['from_user_id'], "whom_user_id"=>(int)$params['whom_user_id'], "text"=>$params['text'], "rating"=>$rating]);

    return true;

}