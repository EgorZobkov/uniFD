public function checkCategoriesByAlias($request=null){
  global $app;

  if($this->categories){

     $end_alias = end($request);

     if($this->categories["alias"][$end_alias]){
          foreach ($this->categories["alias"][$end_alias] as $category_id => $value) {
             $chain = $this->chainCategory($category_id);
             if($chain->chain_build_alias_request == implode("/", $request)){
                $value["chain"] = $chain;
                return (object)$value;
             }
          }                
     }       

  }

  return [];

}