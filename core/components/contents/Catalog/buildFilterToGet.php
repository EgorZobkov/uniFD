public function buildFilterToGet($filter=null){
    global $app;

    mb_parse_str($filter, $result);

    $_GET['filter'] = $result["filter"];

}