public function edit()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->blog_posts->find('id=?', [$_POST['id']]);

    if(!$data) return json_answer(["status"=>false, "answer"=>code_answer("record_not_found")]);

    $answer = [];

    if($this->validation->requiredField($_POST['title'])->status == false){
        $answer['title'] = $this->validation->error;
    }

    if($this->validation->requiredField($_POST['alias'])->status == false){
        $answer['alias'] = $this->validation->error;
    }  

    if($this->validation->requiredField($_POST['category_id'])->status == false){
        $answer['category_id'] = $this->validation->error;
    }

    if(empty($answer)){

        $this->model->blog_posts->update(["title"=>$_POST['title'], "image"=>$_POST['manager_image'] ?: null, "alias"=>slug($_POST['alias']), "category_id"=>(int)$_POST['category_id'], "status"=>(int)$_POST['status'], "seo_desc"=>$_POST['seo_desc'] ?: null], $_POST['id']);

        return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }

}