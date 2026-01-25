public function loadTemplateFilterItems()
{

    $items = '';

    $getIdFilters = $this->component->ads_filters->getFiltersByCategory($_POST['id']);

    if($getIdFilters){

         $getFilters = $this->model->ads_filters->sort("sorting asc")->getAll("status=? and id IN(".implode(",", $getIdFilters).")", [1]);

         if($getFilters){

            foreach ($getFilters as $key => $value) {

                $items .= '<div class="filter-template-item" > '.translateField($value["name"]).': <span class="copyToClipboard" >{'.$value["id"].'}</span> </div>';

            }

            return json_answer(['content'=>$items]);

         }

    }

    return json_answer(['content'=>'<div class="filter-template-item" >'.translate("tr_fc02fd451c3f9ffae8d60144fca321d7").'</div>']);

}