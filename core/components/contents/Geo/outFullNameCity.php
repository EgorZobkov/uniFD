public function outFullNameCity($data=[]){

    $type = $this->locationTypes();

    $result = "";

    if($data["location_type_code"]){
        $result .= _strtolower($type[$data["location_type_code"]]["short"]);
    }

    $result .= translateFieldReplace($data, "name");

    if($data["region_name"]){
        $result .= ', '.translateFieldReplace($data, "region_name");
    }

    return $result;
}