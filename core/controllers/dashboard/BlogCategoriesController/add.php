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
 
    if(empty($answer)){

        $params["status"] = (int)$_POST['status'];
        $params["name"] = $_POST['name'];
        $params["alias"] = slug($_POST['alias']);
        $params["parent_id"] = (int)$_POST['parent_id'];
        $params["image"] = $_POST["manager_image"] ?: null;
        $params["seo_title"] = $_POST['seo_title'];
        $params["seo_desc"] = $_POST['seo_desc'];
        $params["seo_h1"] = $_POST['seo_h1'];
        $params["seo_text"] = $_POST['seo_text'] ? urldecode($_POST['seo_text']) : $_POST['seo_text'];

        $this->model->blog_categories->insert($params);

        $this->session->setNotifyDashboard('success', code_answer("add_successfully"));

        return json_answer(["status"=>true]);

    }else{
        return json_answer(["status"=>false, "type_answer"=>"error", "type_show"=>"form", "answer"=>$answer]);
    }    

}