public function checkGeo($data=[]){
    global $app;

    $geo = $app->session->get("geo");

    if($geo){

        if($data["city"]){
            foreach ($data["city"] as $key => $value) {
                if($geo->city_id == $value){
                    return true;
                }
            }
        }
        if($data["region"]){
            foreach ($data["region"] as $key => $value) {
                if($geo->region_id == $value){
                    return true;
                }                
            }
        }
        if($data["country"]){
            foreach ($data["country"] as $key => $value) {
                if($geo->country_id == $value){
                    return true;
                }                
            }
        }

    }

    return false;

}