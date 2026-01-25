public function getDataByValue($data=[]){
    global $app;

    $data["category"] = (object)$app->component->ads_categories->categories[$data["category_id"]];
    $data["geo"] = $app->component->geo->getCityData($data["city_id"]);
    $data["user"] = $app->model->users->findById($data["user_id"], false, true);
    $data["media"] = $this->getMedia($data["media"]);
    $data["contacts"] = (object)_json_decode(decrypt($data["contacts"]));

    return (object)$data;

}