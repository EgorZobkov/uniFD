public function getChange(){
    global $app;

    $geo = $app->session->get("geo");

    if($geo){
        return $geo;
    }

    return [];

}