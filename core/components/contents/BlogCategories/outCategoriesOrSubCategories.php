public function outCategoriesOrSubCategories(){
    global $app;

    if($this->categories){

        if($app->component->blog->data->category){

          if($this->categories["parent_id"][$app->component->blog->data->category->id]){

              foreach ($this->categories["parent_id"][$app->component->blog->data->category->id] as $key => $value) {

                $active = '';

                if($app->component->blog->data->category){
                    if($app->component->blog->data->category->id == $value["id"]){
                        $active = "active";
                    }
                }

                echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active])->includeComponent('items/blog-view-categories.tpl');

              }

          }else{

              $id = $this->categories[$app->component->blog->data->category->parent_id]["id"];

              if($id){
                  foreach ($this->categories["parent_id"][$id] as $key => $value) {

                    $active = '';

                    if($app->component->blog->data->category){
                        if($app->component->blog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active])->includeComponent('items/blog-view-categories.tpl');

                  }
              }else{
                  foreach ($this->getMainCategories() as $key => $value) {

                    $active = '';

                    if($app->component->blog->data->category){
                        if($app->component->blog->data->category->id == $value["id"]){
                            $active = "active";
                        }
                    }

                    echo $app->view->setParamsComponent(['value'=>$value, "active"=>$active])->includeComponent('items/blog-view-categories.tpl');

                  }                    
              }

          }


        }else{

          foreach ($this->getMainCategories() as $key => $value) {

            echo $app->view->setParamsComponent(['value'=>$value])->includeComponent('items/blog-view-categories.tpl');

          }

        }

    }

}