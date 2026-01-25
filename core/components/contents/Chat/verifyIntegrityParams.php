public function verifyIntegrityParams($params=[]){
    global $app;

    if($params){
        $token = $params["token"];
        unset($params["token"]);
        if($token == md5(implode(".", $params).'.'.$app->config->app->signature_hash)){
            return true;
        }
    }

    return false;

}