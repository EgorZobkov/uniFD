public function clearFilters(){

    $params = [];
    $url = trim(urldecode($_POST['url']), "/");

    if($url){

        $query = explode("?", $url);

        if($query[1]){
            parse_str($query[1], $params);
            if($params["filter"]) unset($params["filter"]);       
        }

        $url = parse_url(getHost(true, false).'/'.$url, PHP_URL_PATH);

        $last = end(explode("/", $url));

        $filter_link = $this->model->ads_filters_links->find('alias=?', [$last]);
        if($filter_link){

            $category = $this->component->ads_categories->checkCategoriesByIdCatalog($filter_link->category_id);

            if($params){
                return json_answer(["link"=>$this->component->ads_categories->buildAliases((array)$category).'?'.http_build_query($params)]);   
            }else{
                return json_answer(["link"=>$this->component->ads_categories->buildAliases((array)$category)]);
            }

        }else{

            if($params){ 
                return json_answer(["link"=>getHost(true, false).'/'.$query[0].'?'.http_build_query($params)]);  
            }else{
                return json_answer(["link"=>getHost(true, false).'/'.$query[0]]);
            }

        }

    }

    return json_answer(["link"=>$url]);

}