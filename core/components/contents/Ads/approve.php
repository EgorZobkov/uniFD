public function approve($ad_id=0){
    global $app;

    $data = $this->getAd($ad_id);

    if(!$data) return;

    $detect_status = $this->detectApproveStatus($ad_id, $data->user_id, $data->category_id);

    $expiration = $this->calculationTimeExpiration($data->publication_period);

    $app->model->ads_data->cacheKey(["id"=>$ad_id])->update(["status"=>$detect_status->status, "reason_blocking_code"=>null, "block_forever_status"=>0, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days], $ad_id);

    $app->component->ads_counter->updateCount($data->category_id, $data->city_id, $data->region_id, $data->country_id, $detect_status->status);

    $app->event->publicationAd($data);

}