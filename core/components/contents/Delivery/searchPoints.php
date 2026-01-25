public function searchPoints($point_id=0, $query=null){
    global $app;

    $result = [];

    $delivery = $app->model->system_delivery_services->find("id=?", [(int)$point_id]);

    if($delivery){
        $data = $app->model->delivery_points->sort("address asc limit 100")->search($query)->getAll("delivery_id=?",[$delivery->id]);
    }else{
        $data = $app->model->delivery_points->sort("address asc limit 100")->search($query)->getAll();
    }

    if($data){

        foreach ($data as $value) {

            $result[] = ["id"=>$value["id"], "delivery_id"=>$value["delivery_id"]?:0, "address"=>$value["address"], "latitude"=>$value["latitude"]?:0, "longitude"=>$value["longitude"]?:0, "point_code"=>$value["code"]];

        }

    }

    return $result;

}