public function blockingAd($data = []){
    global $app;

    $app->notify->params(["ad_title"=>$data->title, "ad_link"=>$app->component->ads->buildAliasesAdCard($data), "text"=>$data->reason_text])->userId($data->user->id)->code("board_ad_blocked")->addWaiting(); 

}