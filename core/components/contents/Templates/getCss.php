public function getCss(){
    global $app;

    $list = glob($app->config->resource->assets->web->css.'/*.css');

    if(count($list)){
        foreach ($list as $file){
            $filename = getInfoFile($file)->filename;
            if($filename == "main"){
                echo '<a href="'.$app->router->getRoute("dashboard-template-view-css", [$filename]).'" class="list-group-item list-group-item-action d-flex justify-content-between"><div class="li-wrapper d-flex justify-content-start align-items-center" >'.$filename.'</div><div><span class="badge badge-small bg-label-warning mb-1">'.translate("tr_57909986c8d97e90e748540935ffb5b6").'</span></div></a>';
            }else{
                echo '<a href="'.$app->router->getRoute("dashboard-template-view-css", [$filename]).'" class="list-group-item list-group-item-action">'.$filename.'</a>';
            }
        }
    }

}