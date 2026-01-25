public function getCodeStatus($name=null){
    global $app;

    $code = $this->codeStatuses();

    return $code[$name] ? (object)$code[$name] : [];

}