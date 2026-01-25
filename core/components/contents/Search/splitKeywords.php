public function splitKeywords($query=null){
    global $app;

    $query = str_replace(["#","№","%",",", "[", "]", "{", "}", "_"], "", $query);

    if($query){
        if($app->settings->search_stopwords){
            foreach ($app->settings->search_stopwords as $value) {
               $query = preg_replace('/\b'.trim($value).'\b/u','',$query);
            }
        }

        $split = preg_split("/( )+/", $query);
    }

    return ["query"=>$query, "split"=>$split];

}