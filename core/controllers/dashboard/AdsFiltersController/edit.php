public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getFilter = $this->model->ads_filters->find('id=?', [$_POST['id']]);

    if(!$getFilter) return json_answer(["status"=>true, "type_answer"=>"error", "type_show"=>"notice", "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['view'])->status == false){
        $answer['view'] = $this->validation->error;
    }

    if($getFilter->parent_id){
        if($this->validation->requiredField($_POST['filter_item_id'])->status == false){
            $answer['filter_item_id'] = $this->validation->error;
        }            
    }else{
        if($this->validation->isSelectedCategories($_POST['categories'])->status == false){
            $answer['categories'] = $this->validation->error;
        }
    }

    if($_POST['view'] != 'input_text'){
        if($this->validation->requiredItemsFilters($_POST['items'])->status == false){
            $answer['items'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->ads_filters->update(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "required"=>(int)$_POST['required'], "view"=>$_POST['view'], "item_sorting"=>$_POST['item_sorting'], "default_status"=>(int)$_POST['default_status']], $getFilter->id);  

        if(!$getFilter->parent_id){

            $this->model->ads_filters_categories->delete("filter_id=?", [$getFilter->id]);

            foreach ($_POST['categories'] as $category_id) {
                $this->model->ads_filters_categories->insert(["category_id"=>$category_id, "filter_id"=>$getFilter->id]);
            }

            $parent_filter_ids = $this->component->ads_filters->getParentIds($getFilter->id);

            if($parent_filter_ids){
                foreach (explode(",", $parent_filter_ids) as $filter_id) {
                    $this->model->ads_filters_categories->delete("filter_id=?", [$filter_id]);
                    foreach ($_POST['categories'] as $category_id) {
                        $this->model->ads_filters_categories->insert(["category_id"=>$category_id, "filter_id"=>$filter_id]);
                    }
                }
            }

        }

        $sorting = 1;
        $idsNotDelete = [];

        if($_POST['view'] != 'input_text'){

            foreach ($_POST["items"] as $action => $nested) {
                foreach ($nested as $id => $value) {
                
                    if(trim($value) != ""){
                      if($action == "add"){
                         $item_insert_id = $this->model->ads_filters_items->insert(["filter_id"=>$getFilter->id, "name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting, "item_parent_id"=>$_POST['filter_item_id']?:0]);
                         $idsNotDelete[$item_insert_id] = $item_insert_id;
                      }elseif($action == "edit"){
                         $this->model->ads_filters_items->update(["name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting], $id);
                         $idsNotDelete[$id] = $id;
                      }
                    }

                    $sorting++;
                
                }
            }

            if($idsNotDelete){
                if(isset($_POST['filter_item_id'])){
                    $this->model->ads_filters_items->delete("filter_id=? and item_parent_id=? and id NOT IN(".implode(",", $idsNotDelete).")", [$getFilter->id,$_POST['filter_item_id']]);
                }else{
                    $this->model->ads_filters_items->delete("filter_id=? and id NOT IN(".implode(",", $idsNotDelete).")", [$getFilter->id]);
                }
            }

        }

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
        
    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}