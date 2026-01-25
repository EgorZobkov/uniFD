public function getAllReasonsBlocking(){
    global $app;

    $result = [];

    foreach ($this->reasonsBlocking() as $key => $value) {
        $result[$key] = $value;
    }

    $getReasons = $app->model->system_reasons_blocking->getAll();
    if($getReasons){
        foreach ($getReasons as $value) {
            $result[$value["code"]] = $value;
        }
    }

    return $result;

}