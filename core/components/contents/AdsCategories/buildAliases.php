public function buildAliases($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    $chain = $this->chainCategory($data["id"]);

    if($geo){
        return outLink($geo->alias . '/' . $chain->chain_build_alias_request);
    }else{
        return outLink($chain->chain_build_alias_request);
    }

}