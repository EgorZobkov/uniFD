public function replaceAllCitiesByCountry($alias=null){
    global $app;

    if($app->router->currentRoute->name == "search-by-map" || $app->router->beforeRouteName == "search-by-map"){
        return outLink('map/' . $alias);
    }

    return outLink($alias);

}