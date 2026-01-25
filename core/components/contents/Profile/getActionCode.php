public function getActionCode($code=null){
    global $app;

    $actionCode = $this->actionsCode();

    return $actionCode[$code] ? (object)$actionCode[$code] : [];

}