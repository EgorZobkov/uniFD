public function getRecursionOptions($parent_id=0, $level=0){

    if ($this->filters){
        foreach ($this->filters["parent_id"][$parent_id] as $value) {

            while ($x++<$level) $retreat .= "-";

            echo '<option value="' . $value["id"] . '" >'.$retreat.translateFieldReplace($value, "name").'</option>';

            $level++;
            
            $this->getRecursionOptions($value["id"], $level);
            
            $level--;
            
        }
    }

}