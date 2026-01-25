public function outSubCategoriesByCatalog(){
    global $app;

    $count_key = 0;

    if($this->categories){
          foreach ($this->categories as $key => $value) {

               if($this->categories["parent_id"][$value["id"]]){
                    
                    $show = '';

                    if( $count_key == 0 ){
                        $show = ' style="display: block;" ';
                    }

                    $count_key++;

                    echo '
                      <div class="big-catalog-menu-content-subcategories" '.$show.' data-id-parent="'.$value["id"].'" >

                      <h4><strong>'.translateFieldReplace($value, "name").'</strong></h4>

                      <div class="row no-gutters mt25" >
                    ';

                        foreach ($this->categories["parent_id"][ $value["id"] ] as $subvalue) {

                            echo '
                               <div class="col-lg-6" >
                                   <a href="'.$this->buildAliases($subvalue).'">'.translateFieldReplace($subvalue, "name").'</a>
                               </div>
                            ';

                        }

                    echo '
                      </div>
                      </div>
                    ';

               }

          }
    }

}