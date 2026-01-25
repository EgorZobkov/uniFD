public function loadAddPodfilter()
{

    $data = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-add-podfilter.tpl')]);

}