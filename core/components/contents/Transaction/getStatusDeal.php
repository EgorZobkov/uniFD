public function getStatusDeal($code=null){
    global $app;

    $statusCode = $this->statusesDeal();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}