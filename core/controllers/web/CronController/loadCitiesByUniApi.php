public function loadCitiesByUniApi(){

    $getImportCountry = $this->model->geo_countries->sort('id asc')->find("status_api_import=?", [1]);

    if($getImportCountry){

        $cities = $this->system->uniApi("cities_load", ["country_id"=>$getImportCountry->temp_id, "page"=>$getImportCountry->page_api_import]);

        if($cities){
            foreach ($cities as $key => $value) {

                if($value["region_id"]){
                    $getRegion = $this->model->geo_regions->find("temp_id=?", [$value["region_id"]]);
                    if($getRegion){
                        $value["region_id"] = $getRegion->id;
                    }
                }

                $value["country_id"] = $getImportCountry->id;

                unset($value["id"]);

                $this->model->geo_cities->insert($value);

            }
            $this->model->geo_countries->update(["page_api_import"=>$getImportCountry->page_api_import+1], $getImportCountry->id);
        }else{
            $this->model->geo_countries->update(["status_api_import"=>2], $getImportCountry->id);
        }

    }

}