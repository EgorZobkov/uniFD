public function outMainCategoriesInAdCreate(){
    global $app;

    $items = '';

    if($this->categories){

        if($this->categories["parent_id"][0]){

              foreach ($this->categories["parent_id"][0] as $key => $value) {

                   $items .= '<span class="ad-create-categories-item" data-id="'.$value["id"].'">'.translateFieldReplace($value, "name").'</span>';

              }

              return $items;
        }

    }

}