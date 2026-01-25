public function checkCategoriesByIdCatalog($category_id=0){
    global $app;

    if($this->categories){

       if($this->categories[$category_id]){
           $chain = $this->chainCategory($category_id);
           $this->categories[$category_id]["chain"] = $chain;
           return (object)$this->categories[$category_id];              
       }       

    }

    return [];

}