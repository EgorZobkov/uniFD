public function getMyReviews($user_id=0){   
    global $app;

    $content = '';

    $data = $app->model->reviews->pagination(true)->page($_GET['page'])->output(10)->sort("id desc")->getAll("whom_user_id=? and status=? and parent_id=?", [$user_id,1,0]);

    if($data){
        foreach ($data as $key => $value) {
           
            $value = $app->component->reviews->getDataByValue($value);

            $content .= $app->view->setParamsComponent(['value'=>(object)$value])->includeComponent('items/review-list.tpl');

        }
    }

    return $content;
    
}