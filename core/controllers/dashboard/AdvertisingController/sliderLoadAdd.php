public function sliderLoadAdd()
{

    $data = $this->model->advertising->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('advertising/slider-load-add.tpl')]);

}