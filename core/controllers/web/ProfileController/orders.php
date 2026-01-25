public function orders()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(compareValues($_GET['tab'], 'buy')){
        $data->orders = $this->component->profile->getFromUserOrders($this->user->data->id);
    }elseif(compareValues($_GET['tab'], 'sell')){
        $data->orders = $this->component->profile->getWhomUserOrders($this->user->data->id);
    }else{
        $data->orders = $this->component->profile->getFromUserOrders($this->user->data->id);
    }
    
    return $this->view->render('profile/orders', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_0905527faec7de502c0e62ce318af892")]]);
}