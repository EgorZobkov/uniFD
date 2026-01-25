public function loadEditKeyword()
{

    $data = $this->model->search_keywords->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('search/load-edit-keyword.tpl')]);

}