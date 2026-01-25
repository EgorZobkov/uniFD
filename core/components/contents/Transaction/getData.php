public function getData($params=[]){   
    global $app;

    $params["user"] = $params["user_id"] ? $app->model->users->findById($params["user_id"]) : [];

    if($params["item_id"]){
        $data = $app->component->ads->getAd($params["item_id"]);
        if($data){
            $params["item_title"] = $data->title;
        }
    }

    return (object)$params;
}