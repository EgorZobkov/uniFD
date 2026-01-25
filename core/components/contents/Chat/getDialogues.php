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