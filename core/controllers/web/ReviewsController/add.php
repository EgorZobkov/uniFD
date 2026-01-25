public function add($user_id)
{   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/reviews.js\" type=\"module\" ></script>"]);

    $data = $this->model->users->findById($user_id, true);

    if(!$data){
        abort(404);
    }else{
        if($data->id == $this->user->data->id){
            abort(404);
        }
    }

    if($_GET['order_id']){
        $order = $this->component->transaction->getDealItem($_GET['order_id']);
        if($order){
            if($order->from_user_id == $this->user->data->id || $order->whom_user_id == $this->user->data->id){
                $data->item = $this->component->ads->getAd($order->item->item_id);
                $data->order_id = $_GET['order_id'];
            }
        }
    }elseif($_GET['item_id']){
        $data->item = $this->component->ads->getAd($_GET['item_id']);
    }

    $data->user_items = $this->model->ads_data->sort("id desc limit 10")->getAll("user_id=? and status IN(1,3,7)", [$data->id]);

    return $this->view->render('review-add', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a1808993eb91e69573b41167cac0fee9")]]);

}