public function outRecursionCategories($categories=[], $parent_id=0, $level=0, $shop_alias=null){

    if ($categories){
        foreach ($categories["parent_id"][$parent_id] as $value) {

            while ($x++<$level) $retreat .= '--';

            echo '<a href="'.$this->buildAliasesCategories($value, $shop_alias).'" >'.$retreat.$value["name"].'</a>';

            $level++;
            
            $this->outRecursionCategories($categories, $value["id"], $level, $shop_alias);
            
            $level--;
            
        }
    }

}