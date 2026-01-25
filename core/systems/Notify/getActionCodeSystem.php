public function getActionCodeSystem($name=null){
    global $app;

    $actionsCode = $this->actionsCodeSystem();

    return $actionsCode[$name] ? (object)$actionsCode[$name] : [];

}