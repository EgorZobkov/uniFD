public function loadEdit()
{

    $data = $this->model->ads_filters->find("id=?", [$_POST['id']]);

    $data->filterCategories = $this->component->ads_filters->getCategories($_POST['id']);
    $data->filterItems = $this->component->ads_filters->getFilterItems($_POST['id']);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/filters/load-edit.tpl')]);

}