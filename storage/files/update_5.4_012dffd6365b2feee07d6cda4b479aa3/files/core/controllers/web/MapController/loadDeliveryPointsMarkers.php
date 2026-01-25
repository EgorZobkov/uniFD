public function loadDeliveryPointsMarkers()
{   

    $data = [];
    $ids = [];
    $result = [];

    $params = _json_decode(urldecode($_POST["params"]));

    if(intval($_POST["id"])){

        $delivery = $this->model->system_delivery_services->find("id=? and status=?", [intval($_POST["id"]), 1]);

        if($delivery){

            if(intval($params["send"])){
                $data = $this->model->delivery_points->getAll("delivery_id=? and send=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [intval($_POST["id"]),1,$_POST["topLeft"]?:null,$_POST["topRight"]?:null,$_POST["bottomLeft"]?:null,$_POST["bottomRight"]?:null]);
            }else{
                $data = $this->model->delivery_points->getAll("delivery_id=? and ((latitude < ? and longitude < ?) and (latitude > ? and longitude > ?))", [intval($_POST["id"]),$_POST["topLeft"]?:null,$_POST["topRight"]?:null,$_POST["bottomLeft"]?:null,$_POST["bottomRight"]?:null]);
            }

        }

        if($data){

            $result = $this->component->geo->mapBuildMarkersByDelivery($data);

        }

    }

    return json_answer($result);

}