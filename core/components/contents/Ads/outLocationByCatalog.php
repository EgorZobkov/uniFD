public function outLocationByCatalog($value=[]){

    $result = [];

    $result[] = translateFieldReplace($value->geo, "name");

    return implode(", ", $result);
    
}