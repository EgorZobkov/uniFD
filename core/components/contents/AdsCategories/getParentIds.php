public function getParentIds($id=0){
    
    $ids = [];

    if($this->joinId){
         $ids[] = $this->joinId;
         $this->joinId = null;
    }

    if($this->categories){
        if(isset($this->categories["parent_id"][$id])){
            foreach ($this->categories["parent_id"][$id] as $key => $value) {
                
                $ids[] = $value["id"];

                if($this->categories["parent_id"][$value["id"]]){
                  $ids[] = $this->getParentIds($value["id"]);
                }

            }
        }
        return isset($ids) ? implode(",", $ids) : '';
    }

    return "";
}