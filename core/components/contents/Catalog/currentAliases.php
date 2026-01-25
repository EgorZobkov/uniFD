public function currentAliases(){
    global $app;

    $request = $app->session->get("request-catalog");

    $geo = $app->session->get("geo");

    if($request){

        return outLink($request->uri);

    }else{

        if($geo){
            return outLink($geo->alias);
        }else{
            return outLink('all');
        }

    }

}