public function chainCategory($id=0){
    global $app;

    $results = [];

    if($this->categories[$id]["parent_id"]){
        $results["chain_array"] = $this->getParentsId($id);
        $results["chain_build"] = $this->getBuildNameChain($results["chain_array"]);
        $results["chain_build_alias_request"] = $this->getBuildAliasRequest($results["chain_array"], "/");
        $results["chain_build_alias_dash"] = $this->getBuildAliasRequest($results["chain_array"], "-");
    }else{
        $results["chain_array"] = [$this->categories[$id]];
        $results["chain_build"] = translateFieldReplace($this->categories[$id], "name");
        $results["chain_build_alias_request"] = translateFieldReplace($this->categories[$id], "alias");
        $results["chain_build_alias_dash"] = translateFieldReplace($this->categories[$id], "alias");
    }

    return (object)$results;

}