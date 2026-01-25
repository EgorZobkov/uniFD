public function getStatusOperation($code=null){
    global $app;

    $statusCode = $this->statusesOperation();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}