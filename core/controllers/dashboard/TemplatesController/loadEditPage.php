public function loadEditPage()
{

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $data = $this->model->template_pages->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('templates/load-edit-page.tpl')]);

}