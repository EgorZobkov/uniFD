public function getFiltersItemsAndViewByCatalog($filters=[], $value=[],$item_id=0){
    global $app;

    $result = '';

    if($value["view"] == "input"){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                    '.$app->ui->buildUniSelectFilters(["input_name_from"=>"filter[".$value["id"]."][from]", "input_name_to"=>"filter[".$value["id"]."][to]","input_value_from"=>$filters[$value["id"]]["from"],"input_value_to"=>$filters[$value["id"]]["to"]], ["view"=>"input", "filter"=>$filters]).'
                </div>
            ';

    }elseif($value["view"] == "input_text"){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                    '.$app->ui->buildUniSelectFilters(["input_name"=>"filter[".$value["id"]."][]","input_value"=>$filters[$value["id"]][0]], ["view"=>"input", "filter"=>$filters]).'
                </div>
            ';

    }else{

        $items = $this->getItems($value,$item_id);

        if($items){

            $checkParent = $app->model->ads_filters->find("status=? and parent_id=?", [1,$value["id"]]);

            if($checkParent){
                $result .= '
                    <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                        <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"radio", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$filters]).'
                    </div>
                ';
            }else{
                $result .= '
                    <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                        <label class="params-form-item-label" >'.translateFieldReplace($value, "name").'</label>
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"multi", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$filters]).'
                    </div>
                ';                    
            }

        }

    }

    return $result;

}