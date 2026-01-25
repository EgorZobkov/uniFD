public function getViewItems($category_id=0){
    global $app;

    if($app->session->get("item-view")){
        return $app->session->get("item-view");
    }else{

        if($app->component->ads_categories->categories[$category_id]["default_view_items_catalog"]){
            return $app->component->ads_categories->categories[$category_id]["default_view_items_catalog"];
        }

    }

    return $app->settings->board_catalog_ad_view ?: "grid";

}