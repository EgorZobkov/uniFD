public function getFiltersItemsAndViewInAdCreate($value=[],$item_id=0,$ad_filters=[]){
    global $app;

    $result = '';
    $required = '';

    if($value["required"]){
        $required = '<span class="params-form-item-label-required" >*</span>';
    }

    if($value["view"] == "input"){

            $result .= '
                <div class="params-form-item" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        <input type="number" name="filter['.$value["id"].'][]" value="'.($ad_filters ? $ad_filters[$value["id"]][0] : '').'" step="0.01" class="form-control" >
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

    }elseif($value["view"] == "input_text"){

            $result .= '
                <div class="params-form-item" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        <input type="text" name="filter['.$value["id"].'][]" value="'.($ad_filters ? $ad_filters[$value["id"]][0] : '').'" class="form-control" >
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

    }elseif($value["view"] == "select"){

        $items = $this->getItems($value,$item_id);

        if($items){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"radio", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$ad_filters]).'
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

        }

    }elseif($value["view"] == "select_multi"){

        $items = $this->getItems($value,$item_id);

        if($items){

            $result .= '
                <div class="params-form-item" data-id="'.$value["id"].'" data-parent-ids="'.$this->getParentIds($value["id"]).'" >
                    <div class="row" >
                        <div class="col-md-6" ><label class="params-form-item-label" >'.translateFieldReplace($value, "name").$required.'</label></div>
                        <div class="col-md-6" >
                        '.$app->ui->buildUniSelectFilters($items, ["view"=>"multi", "input_name"=>"filter[".$value["id"]."][]", "filter"=>$ad_filters]).'
                        <label class="form-label-error" data-name="filter'.$value["id"].'"></label>
                        </div>
                    </div>
                </div>
            ';

        }

    }

    return $result;

}