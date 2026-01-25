function normalizedFiltersArray($filters=[]){
    $results = [];
    if($filters){
        foreach ($filters as $key => $value) {
           if($value['item']) $results[intval($value['filterId'])] = $value['item'];
        }
    }
    return $results;
}