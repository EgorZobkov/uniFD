public function outMapAndOptionsInAdCreate($city_id=0, $data=[]){
    global $app;

    $content = '';
    $districts_items = [];
    $metro_items = [];

    $getDistricts = $app->model->geo_cities_districts->getAll("city_id=?", [intval($city_id)]);
    $getMetro = $app->model->geo_cities_metro->getAll("city_id=? and parent_id!=?", [intval($city_id),0]);

    if($getDistricts){
        foreach ($getDistricts as $key => $value) {
            $districts_items[] = ["item_name"=>$value["name"],"input_name"=>"geo_district_id[]","input_value"=>$value["id"]];
        }
        $content .= '
            <div class="ad-create-options-container-item" >
                  
              <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_1a5241dbf994bc1f4a25da39ae951f58").'</strong> </h5>

              <div class="row" >
                <div class="col-md-6" >
                      '.$app->ui->buildUniSelect($districts_items, ["view"=>"radio", "selected"=>$this->getCityDistrictsByAd($data->id)->ids]).' 
                </div>
              </div>

            </div>
        ';
    }

    if($getMetro){
        foreach ($getMetro as $key => $value) {
            $station = $app->model->geo_cities_metro->find("id=?", [$value["parent_id"]]);
            $metro_items[] = ["item_name"=>'<span class="geo-metro-station-color-label" style="background-color:'.$station->color.';"></span>'.$value["name"].', '.$station->name,"input_name"=>"geo_metro_id[]","input_value"=>$value["id"]];
        }
        $content .= '
            <div class="ad-create-options-container-item" >
                  
              <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_5765747a21bfd298aac39bf20b3b99e8").'</strong> </h5>

              <div class="row" >
                <div class="col-md-6" >
                      '.$app->ui->buildUniSelect($metro_items, ["view"=>"multi", "selected"=>$this->getCityMetroByAd($data->id)->ids]).'  
                </div>
              </div>

            </div>
        ';
    }

    $content .= '
        <div class="ad-create-options-container-item" >
            <h5 class="ad-create-options-container-item-title" > <strong>'.translate("tr_80148fa5ada7bcd36bf3b351ee3ca3b0").'</strong> </h5>

            <div class="input-geo-search-container ad-create-search-address" >
              <input type="text" name="geo_address" class="form-control mt20" placeholder="'.translate("tr_9d66aa312e1e28e241ba5292f8898593").'" value="'.$data->address.'" >
              <div class="input-geo-search-container-result" ></div>
            </div>
            <div class="map-container initMapAddress" id="initMapAddress" ></div>
        </div>
    ';

    return $content;

}