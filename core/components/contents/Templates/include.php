public function include($name=null, $section=null){
    global $app;

    if(isset($name)){

        if($section == "pages"){
            if(file_exists($app->config->resource->view->web->path."/".$name.".tpl")){

                return _file_get_contents($app->config->resource->view->web->path."/".$name.".tpl");

            }
        }elseif($section == "css"){
            if(file_exists($app->config->resource->assets->web->css."/".$name.".css")){

                return _file_get_contents($app->config->resource->assets->web->css."/".$name.".css");

            }
        }elseif($section == "js"){
            if(file_exists($app->config->resource->assets->web->js."/".$name.".js")){

                return _file_get_contents($app->config->resource->assets->web->js."/".$name.".js");

            }
        }

    }

    return '';

}