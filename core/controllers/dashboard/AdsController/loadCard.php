public function loadCard()
{

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }
    
    $data = $this->component->ads->getAd($_POST['id']);
    return json_answer(['content'=>$this->view->setParamsComponent(['data'=>$data])->includeComponent('board/ads/load-card.tpl')]);
}