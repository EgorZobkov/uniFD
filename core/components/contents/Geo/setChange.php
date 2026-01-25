public function setChange($id=0, $purpose=null){
    global $app;

    if($purpose == "city"){

        $data = $this->getCityData($id);

        if($data){

            if($this->statusMultiCountries()){

                if($data->region){
                    $alias = $data->country->alias . '/' . $data->region->alias . '/' . $data->alias;
                }else{
                    $alias = $data->country->alias . '/' . $data->alias;
                }

            }else{

                if($data->region){
                    $alias = $data->region->alias . '/' . $data->alias;
                }else{
                    $alias = $data->alias;
                }

            }

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"city", "alias"=>$alias, "country_id"=>$data->country->id, "region_id"=>$data->region->id, "city_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "declension"=>$data->declension, "latitude"=>$data->latitude?:null, "longitude"=>$data->longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "region"){

        $data = $this->getRegionData($id);

        if($data){

            if($this->statusMultiCountries()){

                $alias = $data->country->alias . '/' . $data->alias;

            }else{

                $alias = $data->alias;

            }

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"region", "alias"=>$alias, "country_id"=>$data->country->id, "region_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "latitude"=>$data->capital_latitude?:null, "longitude"=>$data->capital_longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "country"){

        $data = $app->model->geo_countries->find("id=?", [$id]);

        if($data){

            $params = ["data"=>$data, "name"=>$data->name, "change"=>"country", "alias"=>$data->alias, "country_id"=>$data->id, "before_alias"=>$this->getChange()->alias, "latitude"=>$data->capital_latitude?:null, "longitude"=>$data->capital_longitude?:null];

            _setcookie(["key"=>"geo", "value"=>_json_encode(["id"=>$id, "purpose"=>$purpose]),"lifetime"=>$app->datetime->addDay(30)->getTime()]);

            $app->session->setArray("geo", (object)$params);

        }

    }elseif($purpose == "all"){
        $app->session->delete("geo");
        _setcookie(["key"=>"geo", "value"=>"","lifetime"=>time()-3600]);
    }else{
        $app->session->delete("geo");
        _setcookie(["key"=>"geo", "value"=>"","lifetime"=>time()-3600]);
    }

    return $app->session->get("geo") ?: [];

}