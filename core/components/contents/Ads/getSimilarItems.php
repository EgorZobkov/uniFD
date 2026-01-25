public function getSimilarItems($data=[]){
    global $app;

    $content = '';

    if($data->user->service_tariff->items->hiding_competitors_ads){
        $data = $app->model->ads_data->pagination($_GET['page'],100)->sort("id desc")->getAll("user_id=? and status=? and id!=?", [$data->user_id,1,$data->id]);
    }else{
        $data = $app->model->ads_data->pagination($_GET['page'],100)->sort("id desc")->getAll("category_id IN(".$app->component->ads_categories->joinId($data->category_id)->getParentIds($data->category_id).") and status=? and id!=?", [1,$data->id]);
    }

    if($data){

        shuffle($data);

        foreach (array_slice($data, 0, 20) as $key => $value) {
           
            $value = $app->component->ads->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/grid-col5.tpl');

        }
    }

    return $content;

}