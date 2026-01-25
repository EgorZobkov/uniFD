public function outMainCategoriesGrid(){
    global $app;

    $content = '';

    if($this->getMainCategories()){

          foreach ($this->getMainCategories() as $key => $value) {

            $content .= $app->view->setParamsComponent(['value'=>$value])->includeComponent('items/grid-mobile-categories.tpl');

          }

    }

    return $content;

}