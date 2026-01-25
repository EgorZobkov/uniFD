public function loadEditFeed()
{

    $data = $this->model->import_export_feeds->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('import-export/load-edit-feed.tpl')]);

}