public function getRecursionOptions($parent_id=0, $level=0){

    if ($this->categories){
        foreach ($this->categories["parent_id"][$parent_id] as $value) {

            $selected = "";

            if(isset($this->selectedIds)){
                if(is_array($this->selectedIds)){
                    if(in_array($value["id"], $this->selectedIds)){
                        $selected = 'selected=""';
                    }
                }else{
                    if($value["id"] == $this->selectedIds){
                        $selected = 'selected=""';
                    }
                }
            }

            while ($x++<$level) $retreat .= "-";

            echo '<option '.$selected.' value="' . $value["id"] . '" >'.$retreat.translateFieldReplace($value, "name").'</option>';

            $level++;
            
            $this->getRecursionOptions($value["id"], $level);
            
            $level--;
            
        }
    }

}