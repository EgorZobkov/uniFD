public function buildKeywordsFields($tags=[],$fields=[]){
    global $app;

    $result = [];
    $fields_result = [];
    
    if($fields){

        foreach ($fields as $key => $value) {
            $fields_result[] = $value.' LIKE ?';
        }

    }

    if($tags && $fields_result){

        foreach ($tags as $key => $value) {

            $result["query"][] = '('.implode(" or ", $fields_result).')';

            foreach ($fields_result as $key2 => $value2) {
                $result["params"][] = '%'.$value.'%';
            }

        }

    }

    return ["query"=>implode(" and ", $result["query"]), "params"=>$result["params"]];

}