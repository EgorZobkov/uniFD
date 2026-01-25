public function checkCategoriesByAliasShop($request=null){
     global $app;

     if($app->component->ads_categories->categories){

        $end_alias = end($request);

        if($app->component->ads_categories->categories["alias"][$end_alias]){
             foreach ($app->component->ads_categories->categories["alias"][$end_alias] as $category_id => $value) {
                $chain = $app->component->ads_categories->chainCategory($category_id);
                if($chain->chain_build_alias_request == implode("/", $request)){
                   $value["chain"] = $chain;
                   return (object)$value;
                }
             }                
        }       

     }

     return [];

}