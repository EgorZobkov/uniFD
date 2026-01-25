public function getActionCode($name=null){
    global $app;

    $actionsCode = $this->actionsCode();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}