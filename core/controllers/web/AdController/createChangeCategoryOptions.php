public function createChangeCategoryOptions(){   

    $items = '';
    $options = [];
    $price_currency_list = '';
    $measurements = [];
    $price_fixed_change = '';
    $price_gratis_status = '';
    $ad = [];

    if($this->component->ads_categories->categories){

        if($this->component->ads_categories->categories["parent_id"][$_POST['category_id']]){

              if($_POST['category_id']){
                  $items .= '
                    <button class="btn-custom button-color-scheme2 mb15 ad-create-categories-back" data-id="'.$this->component->ads_categories->categories[$_POST['category_id']]["parent_id"].'" >'.translate("tr_2b0b0225a86bb67048840d3da9b899bc").'</button>
                  ';
              }

              foreach ($this->component->ads_categories->categories["parent_id"][$_POST['category_id']] as $key => $value) {

                   $items .= '<span class="ad-create-categories-item" data-id="'.$value["id"].'">'.translateFieldReplace($value, "name").'</span>';

              }

              return json_answer(["subcategories"=>true,"content"=>$items]);

        }else{

            if($_POST['ad_id']){
                $ad = $this->component->ads->getAd($_POST['ad_id'], $this->user->data->id);
            }

            return json_answer(["subcategories"=>false, "content"=>$this->component->ads->getContentAndOptions($_POST,$ad)]);

        }

    }


}