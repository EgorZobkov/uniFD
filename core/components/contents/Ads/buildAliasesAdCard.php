public function buildAliasesAdCard($data=[]){
    global $app;

    $chain = $app->component->ads_categories->chainCategory($data->category_id);

    if($data->geo){
        return outLink($data->geo->alias . '/' . $chain->chain_build_alias_dash . '/' . $data->alias . '-' . $data->id);
    }else{
        return outLink($chain->chain_build_alias_dash . '/' . $data->alias . '-' . $data->id);
    }
    
}