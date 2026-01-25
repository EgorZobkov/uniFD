public function fileExists($name=null, $section=null){
    global $app;

    if(isset($name)){

        if($section == "pages"){
            if(file_exists($app->config->resource->view->web->path."/".$name.".tpl")){
                return true;
            }
        }elseif($section == "css"){
            if(file_exists($app->config->resource->assets->web->css."/".$name.".css")){
                return true;
            }
        }elseif($section == "js"){
            if(file_exists($app->config->resource->assets->web->js."/".$name.".js")){
                return true;
            }
        }

    }

    return false;

}