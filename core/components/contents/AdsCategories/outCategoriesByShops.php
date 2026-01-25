public function outCategoriesByShops($category_id=0){
    global $app;

    if($this->categories){

          foreach ($this->getMainCategories() as $key => $value) {

            $active = '';

            if($category_id == $value["id"]){
                $active = 'class="active"';
            }

            echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active])->includeComponent('items/shops-view-categories.tpl');

          }

    }

}