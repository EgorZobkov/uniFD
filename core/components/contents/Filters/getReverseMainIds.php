function getReverseMainIds($id=0){

    if($this->filters){

        if($this->filters[$id]["parent_id"] != 0){
            $result[] = $this->getReverseMainIds($this->filters[$id]["parent_id"]);
        }

        $result[] = $id;

        return trim(implode(',',$result), ",");

    }

    return ""; 
           
}