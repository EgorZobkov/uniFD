public function loadMarkers()
{   

    $content = '';
    $data = [];
    $ids = [];
    $result = [];

    $page = (int)$_POST["page"] ? (int)$_POST["page"] : 1;

    $this->pagination->request($_POST);

    $build = $this->component->catalog->buildQuery($_POST, intval($_POST["c_id"]), $this->session->get("geo"));

    if($build){
        $build["query"] = $build["query"] . " and " . "(((address_latitude < ? and address_longitude < ?) and (address_latitude > ? and address_longitude > ?)) or ((geo_latitude < ? and geo_longitude < ?) and (geo_latitude > ? and geo_longitude > ?)))";
        $build["params"][] = $_POST["topLeft"];     
        $build["params"][] = $_POST["topRight"];
        $build["params"][] = $_POST["bottomLeft"];
        $build["params"][] = $_POST["bottomRight"];       
        $build["params"][] = $_POST["topLeft"];     
        $build["params"][] = $_POST["topRight"];
        $build["params"][] = $_POST["bottomLeft"];
        $build["params"][] = $_POST["bottomRight"];

        $data = $this->model->ads_data->getAll($build["query"], $build["params"]);
    }

    if($data){

        $result = $this->component->geo->mapBuildMarkersByAds($data);

    }

    return json_answer($result);

}