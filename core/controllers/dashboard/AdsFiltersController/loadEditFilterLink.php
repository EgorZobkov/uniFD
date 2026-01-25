public function loadEditFilterLink()
{

    $data = $this->model->ads_filters_links->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-edit-link.tpl')]);

}