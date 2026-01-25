public function status($status=0){
    global $app;

    $statuses = $this->allStatuses();

    return (object)$statuses[$status];

}