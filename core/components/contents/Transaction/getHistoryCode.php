public function getHistoryCode($name=null){
    global $app;

    $historyCode = $this->codeHistoryDeal();

    return $historyCode[$name] ? (object)$historyCode[$name] : [];

}