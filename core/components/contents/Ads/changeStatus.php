public function changeStatus($ad_id=0, $status=0, $reason_code=null, $block_forever_status=0){
    global $app;

    $data = $this->getAd($ad_id);

    if(!$data) return;

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["status"=>$status, "reason_blocking_code"=>$reason_code?:null, "block_forever_status"=>$block_forever_status ? 1 : 0], $ad_id);

    if($data->status != $status){

        if($status == 1){

            $expiration = $this->calculationTimeExpiration($data->publication_period);

            $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $ad_id); 

            $app->event->publicationAd($data);

        }elseif($status == 4){
            if(isset($reason_code)){
                $getReason = $app->system->getReasonBlocking($reason_code);
                $data->reason_text = $getReason->text;
            }
            $app->event->blockingAd($data); 
        }

        $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $status);
    }

}