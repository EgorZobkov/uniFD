public function outReverseCategories($id=0){
    global $app;

    $content = '';
    $items = [];
    $reverseIds = [];

    if($id){

        $mainIds = $this->getReverseMainIds($id);

        $mainIdsArray = explode(",", $mainIds);

        foreach ($mainIdsArray as $key => $value) {
            $reverseIds[$value] = $mainIdsArray[$key+1] ?: 0;
        }

        if(count($mainIdsArray) > 1){

            foreach ($this->categories["parent_id"][0] as $value) {
                
                $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

            }   

            $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>$mainIdsArray[0]]);

            foreach ($reverseIds as $category_id => $subcategory_id) {

                $items = [];

                if($this->categories["parent_id"][$category_id]){

                    foreach ($this->categories["parent_id"][$category_id] as $value) {
                        
                        $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

                    }   

                    $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>explode(",", $mainIds), "no_selected"=>["input_name"=>"", "input_value"=>$category_id]]); 
                      
                }

            }            

        }else{

            foreach ($this->categories["parent_id"][0] as $value) {
                
                $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

            }   

            $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "selected"=>$id]);

            $items = [];

            if($this->categories["parent_id"][$id]){

                foreach ($this->categories["parent_id"][$id] as $value) {
                    
                    $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];

                }   

                $content .= $app->ui->buildUniSelect($items, ["view"=>"radio", "no_selected"=>["input_name"=>"", "input_value"=>$category_id]]); 
                  
            }

        }

    }else{

        foreach ($this->getMainCategories() as $value) {
            $items[] = ["item_name"=>translateFieldReplace($value, "name"),"input_name"=>"","input_value"=>$value["id"]];
        }  

        $content = $app->ui->buildUniSelect($items, ["view"=>"radio"]);

    }

    return $content;

}