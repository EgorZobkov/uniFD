public function save()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    parse_str(urldecode($_POST['content']), $_POST);

    $data = $this->model->seo_content->find("page_id=?", [$_POST["id"]]);

    if($data){

        if(trim($data->content) && _json_decode($data->content)){
            $content = array_merge(_json_decode($data->content), $_POST['content']);
        }else{
            $content = $_POST['content'];
        }

        $this->model->seo_content->update(["content"=>_json_encode($content)], ["page_id=?", [$_POST['id']]]);
        
    }else{
        $this->model->seo_content->insert(["page_id"=>$_POST['id'], "content"=>_json_encode($_POST['content'])]);
    }

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);
    
}