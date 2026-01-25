public function getUrlParamsOptionsCity(){
    global $app;

    $params = [];

    if($_GET["city_districts"]){
        if(is_array($_GET["city_districts"])){
            foreach (array_slice($_GET["city_districts"], 0, 100) as $key => $value) {
                $params["city_districts"][] = $value;
            }
        }
    }

    if($_GET["city_metro"]){
        if(is_array($_GET["city_metro"])){
            foreach (array_slice($_GET["city_metro"], 0, 100) as $key => $value) {
                $params["city_metro"][] = $value;
            }
        }
    }

    return $params ? '?'.http_build_query($params) : '';

}