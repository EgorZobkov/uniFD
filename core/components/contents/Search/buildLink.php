public function buildLink($link=null, $keyword_id=0, $marker=null){

    $url_params = "";

    if($link){
        $split = explode("?", $link);

        if(trim($split[1], "/")){
            $url_params = $split[1]."&keyword_id=".$keyword_id."&s_marker=".$marker;
        }else{
            $url_params = "keyword_id=".$keyword_id."&s_marker=".$marker;
        }

        $link = $split[0] . '?' . $url_params;
    }

    return $link;

}