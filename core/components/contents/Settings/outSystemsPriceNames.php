public function outSystemsPriceNames($view=null, $id=0){
    global $app;

    $result = $app->model->system_price_names->getAll();
    if($result){
        foreach ($result as $key => $value) {
            if($view == "option"){
                if($id){
                    if($id == $value["id"]){
                        echo '<option value="'.$value["id"].'" selected="" >'.translateField($value["name"]).'</option>';
                    }else{
                        echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                    }
                }else{
                    echo '<option value="'.$value["id"].'" >'.translateField($value["name"]).'</option>';
                }
            }else{
                echo '<div class="settings-system-price-names-item mb-2" ><div class="col-12 col-md-6" ><div class="input-group"><input type="text" class="form-control" name="system_price_names[update]['.$value["id"].']" value="'.translateField($value["name"]).'"><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemPriceNames"><i class="ti ti-trash"></i></span></div></div></div>';
            }
        }
    }

}