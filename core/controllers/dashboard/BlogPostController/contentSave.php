public function contentSave()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $content = [];

    parse_str(urldecode($_POST['content']), $content);

    $this->model->blog_posts->update(["body"=>$content ? $_POST['body'] : null, "content"=>$content ? _json_encode($content["content"]) : null], $content['id']);

    return json_answer(["status"=>true, "answer"=>code_answer("save_successfully")]);

}