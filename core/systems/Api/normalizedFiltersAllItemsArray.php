 function normalizedFiltersAllItemsArray($filters=[]){
     $results = [];
     if($filters){
         foreach ($filters as $key => $value) {

            if($value['field'] == "start"){
               if($value['item']) $results[intval($value['filterId'])]["from"] = $value['item'];
            }elseif($value['field'] == "end"){
               if($value['item']) $results[intval($value['filterId'])]["to"] = $value['item'];
            }elseif($value['field'] == "text"){
               if($value['item']) $results[intval($value['filterId'])][] = $value['item'];
            }else{
               if($value['item']) $results[intval($value['filterId'])][] = $value['item'];
            }
            
            
         }
     }
     return $results;
 }