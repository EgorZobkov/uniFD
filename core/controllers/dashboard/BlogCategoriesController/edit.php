public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $getCategory = $this->model->blog_categories->find('id=?', [$_POST['id']]);

    if(!$getCategory) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    if($this->validation->requiredField($_POST['name'])->status == false){
        $answer['name'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($_POST['id'] != $_POST['parent_id']){
      $parentIds = $this->component->blog_categories->joinId($_POST['id'])->getParentIds($_POST['id']);
      if(!$parentIds){
         $getCategory->parent_id = $_POST["parent_id"];
      }else{
         if(!in_array($_POST["parent_id"], explode(",",$parentIds))){
            $getCategory->parent_id = $_POST["parent_id"];
         }
      }
    }

    if(empty($answer)){

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['alias']);
        $params["parent_id"] = $getCategory->parent_id;
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];

        $this->model->blog_categories->cacheKey(["id"=>$getCategory->id])->update($params, $getCategory->id);

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}