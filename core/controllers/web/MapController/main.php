public function main($request=null)
{   

    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad_card.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/map.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/catalog.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if($request){

        if($this->settings->active_countries){

            $request_array = explode("/", trim($request, "/"));

            if($this->component->geo->statusMultiCountries()){

                if(count($request_array) == 1){

                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                }elseif(count($request_array) == 2){
                    
                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                    $data->region = $this->model->geo_regions->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);

                    if(!$data->region){
                        $data->city = $this->model->geo_cities->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);
                        if(!$data->city){
                            abort(404);
                        }
                    }

                }elseif(count($request_array) == 3){
                    
                    $data->country = $this->model->geo_countries->find("alias=? and status=?", [$request_array[0],1]);
                    if(!$data->country){
                        abort(404);
                    }

                    $data->region = $this->model->geo_regions->find("alias=? and status=? and country_id=?", [$request_array[1],1,$data->country->id]);

                    if(!$data->region){
                        abort(404);
                    }

                    $data->city = $this->model->geo_cities->find("alias=? and status=? and region_id=? and country_id=?", [$request_array[2],1,$data->region->id,$data->country->id]);

                    if(!$data->city){
                        abort(404);
                    }

                }

            }else{

                if($request != "all"){

                    if(count($request_array) == 1){

                        $data->region = $this->model->geo_regions->find("alias=? and status=?", [$request_array[0],1]);

                        if(!$data->region){
                            $data->city = $this->model->geo_cities->find("alias=? and status=?", [$request_array[0],1]);
                            if(!$data->city){
                                abort(404);
                            }
                        }

                    }elseif(count($request_array) == 2){
                        
                        $data->region = $this->model->geo_regions->find("alias=? and status=?", [$request_array[0],1]);

                        if(!$data->region){
                            abort(404);
                        }

                        $data->city = $this->model->geo_cities->find("alias=? and region_id=? and status=?", [$request_array[1],$data->region->id,1]);

                        if(!$data->city){
                            abort(404);
                        }

                    }

                }

            }

        }           

        if($data->city){
            $this->component->geo->setChange($data->city->id, "city");
        }elseif($data->region){
            $this->component->geo->setChange($data->region->id, "region");
        }elseif($data->country){
            $this->component->geo->setChange($data->country->id, "country");
        }else{
            $this->session->delete("geo");
        }

    }        

    $seo = $this->component->seo->content();

    return $this->view->render('map', ["data"=>(object)$data, "seo"=>$seo]);

}