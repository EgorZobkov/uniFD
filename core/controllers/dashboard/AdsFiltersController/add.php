public function add()
{
    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }   

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    } 

    if($this->validation->requiredField($_POST['view'])->status == false){
        $answer['view'] = $this->validation->error;
    }

    if($this->validation->isSelectedCategories($_POST['categories'])->status == false){
        $answer['categories'] = $this->validation->error;
    }

    if($_POST['view'] != 'input_text'){
        if($this->validation->requiredItemsFilters($_POST['items'])->status == false){
            $answer['items'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $filter_id = $this->model->ads_filters->insert(["status"=>(int)$_POST['status'], "name"=>$_POST['name'], "alias"=>slug($_POST['alias']), "required"=>(int)$_POST['required'], "view"=>$_POST['view'], "item_sorting"=>$_POST['item_sorting'], "default_status"=>(int)$_POST['default_status']]);  

        if($filter_id){

            foreach ($_POST['categories'] as $key => $value) {
                $this->model->ads_filters_categories->insert(["category_id"=>$value, "filter_id"=>$filter_id]);
            } 

            $sorting = 1;

            if($_POST['view'] != 'input_text'){
               foreach ($_POST["items"] as $action => $nested) {
                 foreach ($nested as $id => $value) {

                    if($action == "add" && trim($value) != ""){
                       $this->model->ads_filters_items->insert(["filter_id"=>$filter_id, "name"=>_ucfirst($value), "alias"=>slug($value), "sorting"=>$sorting]);
                    }

                    $sorting++;
                    
                 }
               }
            }  

        }

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);             

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}