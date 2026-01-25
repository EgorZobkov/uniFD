public function checkSubcategories($id=0){

    if ($this->filters){
        if(isset($this->filters["parent_id"][$id])){
            return true;
        }
    }

    return false;

}