public function changeMultiStatus($adIds=[], $status=0){
    global $app;

    if($adIds){
        foreach ($adIds as $key => $id) {

            $data = $this->getAd($id);

            $app->model->ads_data->cacheKey(["id"=>$id])->update(["status"=>$status, "reason_blocking_code"=>null], $id);

            if($data->status != $status){
            
                if($status == 1){

                    $expiration = $this->calculationTimeExpiration($data->publication_period);

                    $app->model->ads_data->update(["time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $id); 

                    $app->event->publicationAd($data);

                }elseif($status == 3){
                
                    $app->event->blockingAd($data);

                }

                $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $status);

            }

        }
    }

}