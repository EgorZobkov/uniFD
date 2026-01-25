public function shops(){

    $shops_ids = [];

    $getShops = $this->model->shops->getAll("status=?", ["published"]);

    if($getShops){

        foreach ($getShops as $value) {
            $order = $this->model->users_tariffs_orders->find("status=? and user_id=?", [1, $value["user_id"]]);
            if(!$order){
                $shops_ids[] = $value["id"];
            }elseif($order->time_expiration != null && time() > strtotime($order->time_expiration)){
                $shops_ids[] = $value["id"];
            }
        }

        if($shops_ids){
            $this->model->shops->update(["status"=>"blocked"], ["id IN(".implode(",", $shops_ids).")", []]);
        }

    }

}