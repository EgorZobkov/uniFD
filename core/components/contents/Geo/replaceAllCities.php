public function replaceAllCities(){
    global $app;

    $aliases = [];
    
    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    if($app->router->currentRoute->name == "search-by-map" || $app->router->beforeRouteName == "search-by-map"){
        $aliases[] = "map";
    }

    if($geo){

        if($request){
            $result = trim(str_replace($geo->alias, "", $request->uri), "/");
            if($result){
                return outLink(implode("/", $aliases) . '/' . $result);
            }else{
                return outLink(implode("/", $aliases) . '/all');
            }
        }else{
            return outLink(implode("/", $aliases) . '/all');
        }

    }else{

        if($request){
            return outLink(implode("/", $aliases) . '/' . $request->uri);
        }else{
            return outLink(implode("/", $aliases) . '/all');
        }

    }

}