public function addReasonBlocking($text=null){
    global $app;

    if($text){
        $code = generateNumberCode(6);
        $app->model->system_reasons_blocking->insert(["name"=>$text, "text"=>$text, "code"=>$code]);
        return $code;
    }

}