public function getJs(){
    global $app;

    $list = glob($app->config->resource->assets->web->js.'/*.js');

    if(count($list)){
        foreach ($list as $file){
            $filename = getInfoFile($file)->filename;
            echo '<a href="'.$app->router->getRoute("dashboard-template-view-js", [$filename]).'" class="list-group-item list-group-item-action">'.$filename.'</a>';
        }
    }

}