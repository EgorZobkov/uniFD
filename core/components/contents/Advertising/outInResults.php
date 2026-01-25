public function outInResults($index=0, $options=[]){
    global $app;

    $results = '';

    $category_id = $app->component->catalog->data->category->id ?: 0;

    $data = $app->model->advertising->getAll("position=? and status=? and result_index=? and (time_start is null or date(now())>=date(time_start)) and (time_end is null or date(time_end)>=date(now())) and (category_id=? or category_id=0)", ["results",1,$index,$category_id]);
    
    if($app->router->currentRoute->name == "home-load-items"){
        $result_view = "grid";
    }else{
        $result_view = $app->component->catalog->getViewItems($app->component->catalog->data->category->id);
    }

    if($data){

        shuffle($data);

        foreach ($data as $key => $value) {

            if($value["geo"]){

                if(!$this->checkGeo(_json_decode($value["geo"]))){
                    break;
                }

            }

            if($value["lang_iso"]){

                if($app->translate->getChangeLang() != $value["lang_iso"]){
                    break;
                }

            }

            if($value["type"] == "banner"){

                if($value["result_view"] == "list" && $result_view == "list"){
                    $results .= '
                    <div class="advertising-banner-container" >
                        <a class="advertising-banner-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" href="'.$value["link"].'" target="_blank" >
                            <img src="'.$app->storage->name($value["image"])->get().'">
                        </a>
                    </div>
                    ';
                }elseif($value["result_view"] == "grid" && $result_view == "grid"){
                    $results .= '
                    <div class="'.$options["col-grid"].'" >
                        <div class="advertising-banner-grid-container" >
                            <a class="advertising-banner-grid-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" href="'.$value["link"].'" target="_blank" >
                                <img src="'.$app->storage->name($value["image"])->get().'">
                            </a>
                        </div>
                    </div>
                    ';                        
                }

            }else{

                if($value["result_view"] == "list" && $result_view == "list"){
                    $results .= '
                    <div class="advertising-script-container" >
                        <div class="advertising-script-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" >
                            '.urldecode($value["code"]).'
                        </div>
                    </div>
                    ';
                }elseif($value["result_view"] == "grid" && $result_view == "grid"){
                    $results .= '
                    <div class="'.$options["col-grid"].'" >
                        <div class="advertising-script-grid-container" >
                            <div class="advertising-script-grid-item actionAdvertisingClick" data-code="'.$value["uniq_code"].'" >
                                '.urldecode($value["code"]).'
                            </div>
                        </div>
                    </div>
                    ';                        
                }

            }
        }

    }

    return $results;

}