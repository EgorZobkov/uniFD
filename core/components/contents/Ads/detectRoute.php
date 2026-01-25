public function detectRoute($params=[]){
    global $app;

    $ad_data = $this->getAd($params->ad_id);

    if($params->detect_status->status == 0){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 1){
        if($app->settings->paid_services_status){
            return outRoute("ad-publication-success", [$params->ad_id]);
        }else{
            return $this->buildAliasesAdCard($ad_data);
        }
    }elseif($params->detect_status->status == 4){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 5){
        return $this->buildAliasesAdCard($ad_data);
    }elseif($params->detect_status->status == 8){
        return $this->buildAliasesAdCard($ad_data);
    }

}