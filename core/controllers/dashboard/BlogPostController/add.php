 public function add()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

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

        $post_id = $this->model->blog_posts->insert(["title"=>$_POST['title'], "image"=>$_POST['manager_image'] ?: null, "alias"=>slug($_POST['alias']), "category_id"=>(int)$_POST['category_id'], "status"=>(int)$_POST['status'], "time_create"=>$this->datetime->getDate(), "seo_desc"=>$_POST['seo_desc'] ?: null]);

        return json_answer(["status"=>true, "redirect"=>$this->router->getRoute('dashboard-blog-post-content', [$post_id])]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}