public function outSystemsPriceMeasurements($view=null, $ids=null){
    global $app;

    $result = $app->model->system_measurements->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($view == "option"){
                if($ids && is_array(_json_decode($ids))){
                    if(compareValues(_json_decode($ids),$value["id"])){
                        echo '<option value="'.$value["id"].'" selected="" >'.translateField($value["name"]).'</option>';
                    }else{
                        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                    }
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                }
            }else{
                echo '<div class="settings-system-measurement-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_measurement[update]['.$value["id"].']" value="'.translateField($value["name"]).'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemMeasurement"><i class="ti ti-trash"></i></span></div></div></div>';                    
            }
        }
    }

}