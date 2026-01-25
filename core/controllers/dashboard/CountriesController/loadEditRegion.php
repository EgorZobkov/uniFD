public function loadEditRegion()
{

    $data = $this->model->geo_regions->find('id=?', [$_POST['id']]);
    if($data){
        return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('countries/load-edit-region.tpl')]);
    }

}