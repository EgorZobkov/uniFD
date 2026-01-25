public function loadEdit()
{

    $data = $this->model->promo_banners->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('promo-banners/load-edit.tpl')]);

}