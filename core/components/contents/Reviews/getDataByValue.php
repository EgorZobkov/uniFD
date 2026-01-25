public function getDataByValue($value=[]){
    global $app;

    $value["item"] = $app->component->ads->getAd($value["item_id"]);
    $value["from_user"] = $app->model->users->findById($value["from_user_id"]);
    $value["whom_user"] = $app->model->users->findById($value["whom_user_id"]);

    return (object)$value;

}