public function buildAliases($data=[]){
    global $app;

    $chain = $this->chainCategory($data["id"]);

    return outLink('blog/' . $chain->chain_build_alias_request);

}