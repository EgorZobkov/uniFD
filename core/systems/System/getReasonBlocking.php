public function getReasonBlocking($code=null){
    global $app;

    if($code){
        $reasons = $this->getAllReasonsBlocking();
        return (object)$reasons[$code] ?: [];
    }

    return [];

}