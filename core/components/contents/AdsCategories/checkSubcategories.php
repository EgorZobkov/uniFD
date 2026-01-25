public function checkSubcategories($id=0){

    if ($this->categories){
        if(isset($this->categories["parent_id"][$id])){
            return true;
        }
    }

    return false;

}