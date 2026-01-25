public function name($data=[],$shortName=false){
    global $app;

    $join = [];

    if(!is_array($data)){
        $data = (array)$data;
    }

    if($data['name']){
        $join['name'] = _ucfirst($data['name']);
    }

    if($data['surname']){
        if($shortName){
            $join['surname'] = _ucfirst($data['surname'], true) . '.';
        }else{
            $join['surname'] = $data['surname'];
        }
    }

    return $join ? implode(' ', $join) : '';
}