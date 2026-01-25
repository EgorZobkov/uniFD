public function clearOptions()
{   

    $url = trim(urldecode($_POST['url']), "/");

    if($url){

        if(strpos($url, "?") !== false){
            $url = explode("?", $url);
            parse_str($url[1], $params);
            if($params["city_districts"]) unset($params["city_districts"]);
            if($params["city_metro"]) unset($params["city_metro"]);   
            if($params){ 
                return json_answer(["link"=>getHost().'/'.$url[0].'?'.http_build_query($params)]);  
            }else{
                return json_answer(["link"=>getHost().'/'.$url[0]]);
            }        
        }

    }

    return json_answer(["link"=>$url]);

}