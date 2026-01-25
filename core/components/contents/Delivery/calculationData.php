public function calculationData($point_id=0, $item_id=0, $user_id=0){
    global $app;

    $data = (object)[];

    $ad = $app->component->ads->getAd((int)$item_id);

    if($ad && !$ad->delete){

        $delivery_point = $app->model->delivery_points->find("id=?", [(int)$point_id]);

        if($delivery_point){

            $delivery = $app->model->system_delivery_services->find("id=?", [$delivery_point->delivery_id]);

            if($delivery){

                $data->delivery_point = $delivery_point;

                $user_shipping = $app->model->users_shipping_points->find("delivery_id=? and user_id=?", [$delivery_point->delivery_id, $ad->user->id]);

                if($user_shipping){

                    $data->user_shipping_point = $app->model->delivery_points->find("id=?", [$user_shipping->point_id]);

                    if($data){

                        $params = (object)["data"=>$data, "ad"=>$ad];

                        return $app->addons->delivery($delivery->alias)->calculation($params);

                    }

                }

            }

        }

    }

    return [];

}