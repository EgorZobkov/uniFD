public function getStatusDealPayment($code=null){
    global $app;

    $statusCode = $this->statusesDealPayment();

    return $statusCode[$code] ? (object)$statusCode[$code] : [];

}