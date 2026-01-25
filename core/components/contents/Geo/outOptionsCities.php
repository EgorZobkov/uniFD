public function outOptionsCities($city_id=0){
    global $app;

    $result = [];
    $tabs = '';
    $button_clear = '';

    if(!$city_id){
        $city_id = $this->getChange()->city_id ?: 0;
    }

    if($this->countChangeOptionsCity()){
        $button_clear = '<button class="btn-custom button-color-scheme2 mr5 actionClearGeoModal">'.translate("tr_02d901c131a1b8c2d1dd669e1f6c88a5").'</button>';
    }

    $districts = $app->model->geo_cities_districts->sort("name asc")->getAll("city_id=?", [$city_id]);
    $metro = $app->model->geo_cities_metro->sort("name asc")->getAll("city_id=?", [$city_id]);

    if($districts){

        foreach ($districts as $key => $value) {

           $checked = "";
           if(compareValues($_GET['city_districts'], $value["id"])){
                $checked = 'checked=""';
           }

           $result["districts"][] = '
            <div class="form-check">
                <input type="checkbox" name="city_districts[]" class="form-check-input" id="filter-district-'.$value["id"].'" value="'.$value["id"].'" '.$checked.' >
                <label class="form-check-label" for="filter-district-'.$value["id"].'">'.translateFieldReplace($value, "name").'</label>
            </div>
           ';
        }

    }

    if($metro){

        foreach ($metro as $key => $value) {

           $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);

           if($station){

               $checked = "";
               if(compareValues($_GET['city_metro'], $value["id"])){
                    $checked = 'checked=""';
               }

               $result["metro"][] = '
                <div class="form-check">
                    <input type="checkbox" name="city_metro[]" class="form-check-input" id="filter-metro-'.$value["id"].'" value="'.$value["id"].'" '.$checked.' >
                    <label class="form-check-label" for="filter-metro-'.$value["id"].'">'.translateFieldReplace($value, "name").' <i class="modal-metro-station-color" style="background-color:'.$station->color.';" ></i> '.translateFieldReplace($station, "name").'</label>
                </div>
               ';

           }

        }

    }

    if($result["districts"] && $result["metro"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_73d7050e5b86bed85fdc6182c27b7d59").'</div>';
        $tabs .= '<div data-tab="2" >'.translate("tr_bf81bef60d4246393b8391e940a00e3d").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["districts"]).'
        </div>
        <div class="modal-geo-tab-2 modal-geo-tab-content" >
           '.implode("", $result["metro"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>
        ';

    }elseif($result["districts"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_73d7050e5b86bed85fdc6182c27b7d59").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["districts"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>            
        ';

    }elseif($result["metro"]){

        $tabs .= '<div class="active" data-tab="1" >'.translate("tr_bf81bef60d4246393b8391e940a00e3d").'</div>';

        return '
        <div class="modal-geo-tabs" >'.$tabs.'</div>
        <div class="modal-geo-tab-1 modal-geo-tab-content" style="display: block;" >
           '.implode("", $result["metro"]).'
        </div>

        <div class="text-end mt-4">
           '.$button_clear.'
           <button class="btn-custom button-color-scheme1 actionApplyGeoModal">'.translate("tr_130bbbc068f7a58df5d47f6587ff4b43").'</button>
        </div>
        ';

    }


}