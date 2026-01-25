public function outCategoriesOrSubCategoriesByCatalog(){
    global $app;

    $geo = $app->session->get("geo");

    if($this->categories){

        if($app->component->catalog->data->category){

          if($this->categories["parent_id"][$app->component->catalog->data->category->id]){

              foreach ($this->categories["parent_id"][$app->component->catalog->data->category->id] as $key => $value) {

                $active = '';

                if($app->component->catalog->data->category){
                    if($app->component->catalog->data->category->id == $value["id"]){
                        $active = "active";
                    }
                }

                echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

              }

          }else{

              $id = $this->categories[$app->component->catalog->data->category->parent_id]["id"];

              if($id){
                  foreach ($this->categories["parent_id"][$id] as $key => $value) {

                    $active = '';

                    if($app->component->catalog->data->category){
                        if($app->component->catalog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

                  }
              }else{
                  foreach ($this->getMainCategories() as $key => $value) {

                    $active = '';

                    if($app->component->catalog->data->category){
                        if($app->component->catalog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

                  }                    
              }

          }


        }else{

          foreach ($this->getMainCategories() as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>$value, "geo"=>$geo])->includeComponent('items/catalog-view-categories.tpl');

          }

        }

    }

}