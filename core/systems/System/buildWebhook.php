public function buildWebhook($addon=null, $alias=null, $action=null){
    global $app;
    if($action){
        return getHost().'/webhook/'.$app->config->app->private_service_key.'/'.$addon.'/'.$alias.'/'.$action;
    }else{
        return getHost().'/webhook/'.$app->config->app->private_service_key.'/'.$addon.'/'.$alias;
    }
}