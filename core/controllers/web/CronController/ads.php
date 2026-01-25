public function ads(){

    $ids = [];
    $data = [];
    $auto_renewal_data = [];
    $auto_renewal_ids = [];

    $expiration = $this->component->ads->calculationTimeExpiration();

    $getCompletedAds = $this->model->ads_data->sort("id asc limit 500")->getAll("now() >= time_expiration and status=?", [1]);
    
    if($getCompletedAds){

        foreach ($getCompletedAds as $value) {
            if($value["auto_renewal_status"]){
                $auto_renewal_data[] = $value;
                $auto_renewal_ids[] = $value["id"];
            }else{
                $data[] = $value;
                $ids[] = $value["id"];
            }
        }

        if($ids){
            $this->model->ads_data->update(["status"=>2], ["id IN(".implode(",", $ids).") and auto_renewal_status=?", [0]]);
        }

        if($auto_renewal_ids){
            $this->model->ads_data->update(["status"=>1, "time_expiration"=>$expiration->date, "publication_period"=>$expiration->days, "time_sorting"=>$this->datetime->getDate()], ["id IN(".implode(",", $auto_renewal_ids).") and auto_renewal_status=?", [1]]);
        }

        if($data){
            foreach ($data as $key => $value) {

                $value = $this->component->ads->getDataByValue($value);

                $this->notify->params(["ad_title"=>$value->title, "ad_id"=>$value->id, "ad_link"=>$this->component->ads->buildAliasesAdCard($value)])->userId($value->user_id)->code("board_ad_end_term")->addWaiting();

            }
        }

    }

}