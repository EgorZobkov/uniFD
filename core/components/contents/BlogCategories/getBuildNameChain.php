public function getBuildNameChain($data=[]){

    $result = [];

    if($data){
        foreach ($data as $key => $value) {
            $result[] = translateFieldReplace($value, "name");
        }
        return implode(" - ", $result);
    }

    return '';

}