public function loadEditLanguage()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $data = $this->model->languages->find("id=?", [$_POST['id']]);

    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('translates/load-edit-language.tpl')]);

}