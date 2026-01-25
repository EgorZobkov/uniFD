public function outLinkMap(){
    global $app;

    $params = getRequestParams();
    $geo = $app->session->get("geo");

    if($geo){

        if($params){
            return outRoute("search-by-map") . '/' . $geo->alias . "?" . $params;
        }elseif($this->data->category){
            return outRoute("search-by-map") . '/' . $geo->alias . "?c_id=" . $this->data->category->id;
        }else{
            return outRoute("search-by-map") . '/' . $geo->alias;
        }

    }else{

        if($params){
            return outRoute("search-by-map") . "?" . $params;
        }elseif($this->data->category){
            return outRoute("search-by-map") . "?c_id=" . $this->data->category->id;
        }else{
            return outRoute("search-by-map");
        }

    }

}