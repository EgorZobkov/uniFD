public function buildAliasesShops($data=[]){
    global $app;

    $chain = $this->chainCategory($data["id"]);

    return outLink('shops/' . $chain->chain_build_alias_request);

}