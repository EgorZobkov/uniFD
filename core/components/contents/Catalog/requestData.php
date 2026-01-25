public function requestData($main_request=null){
    global $app;

    $data = [];
    $pattern = [];

    $main_request_array = explode("/", trim($main_request, "/"));

    if($app->translate->getChangeLang() == $main_request_array[0]){
        unset($main_request_array[0]);
        $main_request_array = array_values($main_request_array);
    }

    if($app->settings->active_countries){

        if($app->component->geo->statusMultiCountries()){

            $data["country"] = $app->model->geo_countries->find("alias=? and status=?", [$main_request_array[0],1]);
            if($data["country"]){

                unset($main_request_array[0]);

                $main_request_array = array_values($main_request_array);

                $cond_country = "and country_id IN(".$data["country"]->id.")";

            }else{
                abort(404);
            }

        }else{

            if($main_request_array[0] == "all"){
                unset($main_request_array[0]);
            }

            $cond_country = "and country_id IN(".implode(",",$app->settings->active_countries).")";

        }

        if($main_request_array){

            $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);

            if(!$data["category"]){

                $last = end($main_request_array);

                $getFilterLinks = $app->model->ads_filters_links->getAll('alias=?', [$last]);
                if($getFilterLinks){
                    foreach ($getFilterLinks as $key => $value) {
                        if(strpos($main_request, $value["full_aliases"]) !== false){
                            $data["filter_link"] = (object)$value;
                            break;
                        }
                    }
                }

                if($data["filter_link"]){

                    $data["category"] = $app->component->ads_categories->checkCategoriesByIdCatalog($data["filter_link"]->category_id);

                    if(!$_GET["filter"]){
                        $this->buildFilterToGet($data["filter_link"]->params);
                    }else{
                        $app->router->goToUrl($app->component->ads_categories->buildAliases((array)$data["category"])."?".http_build_query($_GET));
                    }

                    $request = trim(str_replace($data["filter_link"]->full_aliases, "", implode("/", $main_request_array)), "/");

                    if($request){
                        $request = explode("/", $request);
                     
                        if(count($request) == 1){

                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$request[0],1]);
                            if(!$data["city"]){
                                $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$request[0],1]);
                                if(!$data["region"]){
                                    abort(404);
                                }                            
                            }else{
                                if($data["city"]->region_id){
                                    abort(404);
                                }
                            }

                        }elseif(count($request) == 2){

                            $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$request[0],1]);
                            if($data["region"]){
                                $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$request[1],$data["region"]->id,1]);
                                if(!$data["city"]){
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }

                        }else{
                            abort(404);
                        }
                    }

                }else{

                    if(count($main_request_array) == 1){

                        $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if(!$data["city"]){
                            $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if(!$data["region"]){
                                abort(404);
                            }                            
                        }else{
                            if($data["city"]->region_id){
                                abort(404);
                            }
                        }               

                    }elseif(count($main_request_array) == 2){

                        $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if($data["region"]){ 
                            $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$main_request_array[1],$data["region"]->id,1]);
                            if(!$data["city"]){
                                unset($main_request_array[0]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }
                        }else{
                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if($data["city"]){
                                if(!$data["city"]->region_id){
                                    unset($main_request_array[0]);
                                    $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                    if(!$data["category"]){
                                        abort(404);
                                    }
                                }else{
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }
                        }        

                    }else{

                        $data["region"] = $app->model->geo_regions->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                        if($data["region"]){
                            $data["city"] = $app->model->geo_cities->find("alias=? and region_id=? and status=? $cond_country", [$main_request_array[1],$data["region"]->id,1]);
                            if($data["city"]){
                                unset($main_request_array[0]);
                                unset($main_request_array[1]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }else{
                                unset($main_request_array[0]);
                                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                if(!$data["category"]){
                                    abort(404);
                                }
                            }
                        }else{
                            $data["city"] = $app->model->geo_cities->find("alias=? and status=? $cond_country", [$main_request_array[0],1]);
                            if($data["city"]){
                                if(!$data["city"]->region_id){
                                    unset($main_request_array[0]);
                                    $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                                    if(!$data["category"]){
                                        abort(404);
                                    }
                                }else{
                                    abort(404);
                                }
                            }else{
                                abort(404);
                            }
                        }

                    }

                }

            }

        }

        if($data["city"]){
            $app->component->geo->setChange($data["city"]->id, "city");
        }elseif($data["region"]){
            $app->component->geo->setChange($data["region"]->id, "region");
        }elseif($data["country"]){
            $app->component->geo->setChange($data["country"]->id, "country");
        }else{
            $app->component->geo->setChange();
        }

    }else{

        $app->component->geo->setChange();

        if($main_request != "all"){

            $data["filter_link"] = $app->model->ads_filters_links->find('full_aliases=?', [$main_request]);

            if(!$data["filter_link"]){

                $data["category"] = $app->component->ads_categories->checkCategoriesByAliasCatalog($main_request_array);
                if(!$data["category"]){
                    abort(404);
                }

            }else{

                $data["category"] = $app->component->ads_categories->checkCategoriesByIdCatalog($data["filter_link"]->category_id);
                if(!$_GET["filter"]){
                    $this->buildFilterToGet($data["filter_link"]->params);
                }else{
                    $app->router->goToUrl($app->component->ads_categories->buildAliases((array)$data["category"])."?".http_build_query($_GET));
                }                

            }

        }

    }

    $this->data = (object)$data;

    $app->session->setArray("request-catalog", (object)["uri"=>clearRequestURI(), "params"=>getRequestParams(), "category_id"=>$this->data->category ? $this->data->category->id : 0]);

    return $this->data;

}