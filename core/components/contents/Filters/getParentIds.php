public function getParentIds($id=0){
    
    $ids = [];

    if($this->filters){
        if(isset($this->filters["parent_id"][$id])){
            foreach ($this->filters["parent_id"][$id] as $key => $value) {
                
                $ids[] = $value["id"];

                if($this->filters["parent_id"][$value["id"]]){
                  $ids[] = $this->getParentIds($value["id"]);
                }

            }
            return isset($ids) ? implode(",", $ids) : '';
        }
    }

    return "";
}