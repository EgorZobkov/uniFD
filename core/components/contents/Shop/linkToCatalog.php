public function linkToCatalog($shop_alias=null){
    global $app;

    return outLink('shop/' . $shop_alias . '/catalog');

}