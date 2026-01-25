public function loadItemsFilter()
{   

    $content = [];

    $filter = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    if($filter->view != "input_text"){

        if($filter->item_sorting == "abs"){
            $items = $this->model->ads_filters_items->getAll("filter_id=? and item_parent_id=? order by name asc", [$_POST['id'],$_POST['item_id']]);
        }else{
            $items = $this->model->ads_filters_items->getAll("filter_id=? and item_parent_id=? order by sorting asc", [$_POST['id'],$_POST['item_id']]);
        }

        if($items){
            foreach ($items as $key => $value) {
                $content[] = '<div class="block-filter-item" ><div class="input-group"><span class="input-group-text"><div class="handle-sorting handle-sorting-move"><i class="ti ti-arrows-sort"></i></div></span><input type="text" class="form-control" name="items[edit]['.$value["id"].']" value="'.translateField($value["name"]).'" ><span class="btn btn-icon btn-label-danger waves-effect buttonDeleteItemFilter"><i class="ti ti-trash"></i></span></div></div>';
            }
        }

    }

    return json_answer(['content'=>implode("", $content)]);

}