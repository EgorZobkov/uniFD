public function getBuildAliasRequest($data=[], $glue="/"){

    $result = [];

    if($data){
        foreach ($data as $key => $value) {
            $result[] = translateFieldReplace($value, "alias");
        }
        return implode($glue, $result);
    }

    return '';

}