public function hasAddToCart($data=[]){
    global $app;

    if($this->hasBuySecureDeal($data) && $app->component->ads_categories->categories[$data->category_id]["marketplace_status"] && $app->settings->basket_status){
        return true;
    }

    return false;

}