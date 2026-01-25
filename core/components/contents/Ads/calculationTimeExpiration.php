public function calculationTimeExpiration($day=0){
    global $app;

    if($day){
        if(compareValues(explode(",", $app->settings->board_publication_term_date_list), $day)){
            return (object)["date"=>$app->datetime->addDay($day)->getDate(), "days"=>$day];
        }
    }

    return (object)["date"=>$app->datetime->addDay($app->settings->board_publication_term_date_default ?: 30)->getDate(), "days"=>$app->settings->board_publication_term_date_default ?: 30];

}