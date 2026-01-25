public function replaceAliases($data=[]){
    global $app;

    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    $aliases = [];

    if($app->router->beforeRouteName == "search-by-map" || $app->router->currentRoute->name == "search-by-map"){

        if($data){

            if($this->statusMultiCountries()){
                $aliases[] = $data["country"]["alias"];
            }

            if($data["region"]){
                $aliases[] = $data["region"]["alias"];
            }

            $aliases[] = $data["alias"];

            if($geo){

                if($request){
                    return outLink('map/' . trim(str_replace($geo->alias, implode("/", $aliases), $request->uri), "/"));
                }else{
                    return outLink('map/' . implode("/", $aliases));
                }

            }else{

                if($request && $request->uri != "all"){
                    $aliases[] = $request->uri;
                }

                return outLink('map/' . implode("/", $aliases));

            }

        }

    }else{

        if($data){

            if($this->statusMultiCountries()){
                $aliases[] = $data["country"]["alias"];
            }

            if($data["region"]){
                $aliases[] = $data["region"]["alias"];
            }

            $aliases[] = $data["alias"];

            if($geo){

                if($request){
                    return outLink(trim(str_replace($geo->alias, implode("/", $aliases), $request->uri), "/"));
                }else{
                    return outLink(implode("/", $aliases));
                }

            }else{

                if($request && $request->uri != "all"){
                    $aliases[] = $request->uri;
                }

                return outLink(implode("/", $aliases));

            }

        }

    }

}