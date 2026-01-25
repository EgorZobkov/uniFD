public function outRegionsOptions($country_id=0, $region_id=0){
    global $app;

    $getRegions = $app->model->geo_regions->sort("name asc")->getAll("country_id=?", [$country_id]);

    if($getRegions){
        foreach ($getRegions as $key => $value) {
            if($region_id){
                if($value["id"] == $region_id){
                    echo '<option value="'.$value["id"].'" selected="" >'.translateFieldReplace($value, "name").'</option>';
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateFieldReplace($value, "name").'</option>';
                }
            }else{
                echo '<option value="'.$value["id"].'" >'.translateFieldReplace($value, "name").'</option>';
            }
        }
    }

}