function getReverseMainIds($id=0){

    if($this->categories){

        if($this->categories[$id]["parent_id"] != 0){
            $result[] = $this->getReverseMainIds($this->categories[$id]["parent_id"]);
        }

        $result[] = $id;

        return trim(implode(',',$result), ",");

    }

    return ""; 
           
}