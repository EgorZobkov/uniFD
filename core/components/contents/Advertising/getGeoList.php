public function getGeoList($data=[]){
    global $app;

    $list = [];

    if($data["city"]){
        $get = $app->model->geo_cities->getAll("id IN(".implode(",", $data["city"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }
    if($data["region"]){
        $get = $app->model->geo_regions->getAll("id IN(".implode(",", $data["region"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }
    if($data["country"]){
        $get = $app->model->geo_countries->getAll("id IN(".implode(",", $data["country"]).")");
        foreach ($get as $key => $value) {
            $list[] = $value["name"];
        }
    }

    return implode(",", $list);

}