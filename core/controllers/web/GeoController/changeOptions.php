public function changeOptions()
{   

    $params = [];

    $url = trim($_POST['geo_alias'], "/");

    if($_POST["city_districts"]){
        $params["city_districts"] = $_POST["city_districts"];
    }

    if($_POST["city_metro"]){
        $params["city_metro"] = $_POST["city_metro"];
    }

    if($_POST["sort"]){
        $params["sort"] = $_POST["sort"];
    }

    if($url){

        $url = parse_url($url, PHP_URL_PATH);

        $last = end(explode("/", $url));

        $filter_link = $this->model->ads_filters_links->find('alias=?', [$last]);

        if(!$filter_link){

            if($_POST["filter"]){
                $params["filter"] = $_POST["filter"];
            }

        }

    }

    if($url){

        if($params){
            return json_answer(["link"=>$url.'?'.http_build_query($params)]);       
        }else{
            return json_answer(["link"=>$url]);
        }     

    }

    return json_answer(["link"=>getHost().'/all']);
    
}