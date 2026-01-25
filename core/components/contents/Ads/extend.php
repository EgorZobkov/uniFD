public function extend($id=0, $user_id=0){
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=? and status=?", [$id, $user_id, 2]);

    if($ad){

        $expiration = $this->calculationTimeExpiration($ad->publication_period);

        $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id); 

    }

}