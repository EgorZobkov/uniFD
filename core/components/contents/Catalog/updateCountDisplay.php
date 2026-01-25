public function updateCountDisplay($ids=[]){
    global $app;

    if(!isBot(getUserAgent()) && $ids){
        $app->model->ads_data->updateQuery("count_display=count_display+1 where id IN(".implode(",", $ids).")");
    }

}