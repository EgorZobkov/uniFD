public function publicationAd($data = []){
    global $app;

    $app->notify->params(["ad_title"=>$data->title, "ad_link"=>$app->component->ads->buildAliasesAdCard($data)])->userId($data->user->id)->code("board_ad_active")->addWaiting();

}