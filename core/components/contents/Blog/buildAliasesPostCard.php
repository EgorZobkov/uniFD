 public function buildAliasesPostCard($data=[]){
    global $app;

    $data = (array)$data;

    $chain = $app->component->blog_categories->chainCategory($data["category_id"]);

    return outLink('blog/' . $chain->chain_build_alias_dash . '/' . translateFieldReplace($data, "alias") . '-' . $data["id"]);
    
}