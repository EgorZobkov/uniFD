public function outSystemStationCityMetro($item_id){
    global $app;

    $result = $app->model->geo_cities_metro->getAll("parent_id=?", [$item_id]);
    if($result){
        foreach ($result as $key => $value) {
            echo '<div class="country-city-metro-item mb-2" ><div class="input-group"><input type="text" class="form-control" name="stations[update]['.$value["id"].']" value="'.translateFieldReplace($value, "name").'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemCityMetro"><i class="ti ti-trash"></i></span></div></div>';
        }
    }

}