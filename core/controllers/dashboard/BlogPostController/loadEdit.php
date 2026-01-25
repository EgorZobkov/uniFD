public function loadEdit()
{

    $data = $this->model->blog_posts->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('blog/load-edit-post.tpl')]);

}