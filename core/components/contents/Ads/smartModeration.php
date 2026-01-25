public function smartModeration($user_id=0){
    global $app;

    $personal_rating = 0;

    $user = $app->user->getData($user_id);

    $countMinReviews = $app->model->reviews->count("whom_user_id=? and status=? and rating IN(1,2,3)", [$user_id,1]);
    $countMaxReviews = $app->model->reviews->count("whom_user_id=? and status=? and rating IN(4,5)", [$user_id,1]);

    if($countMinReviews && $countMaxReviews){

        if($countMaxReviews > $countMinReviews){
            $personal_rating += 10;
        }

    }elseif($countMaxReviews){

        $personal_rating += 20;

    }

    $countAds = $app->model->ads_data->count("user_id=? and status IN(1,2,3,6,7)", [$user_id]);

    if($countAds <= 10){
        $personal_rating += 10;
    }elseif($countAds > 10){
        $personal_rating += 20;
    }

    $countComplaints = $app->model->complaints->count("whom_user_id=? and status=?", [$user_id,1]);

    if(!$countComplaints){
        $personal_rating += 10;
    }

    $countDeals = $app->model->transactions_deals->count("(from_user_id=? or whom_user_id=?) and status_payment=? and status_completed=?", [$user_id,$user_id,1,1]);

    if($countDeals <= 10){
        $personal_rating += 10;
    }elseif($countDeals > 10){
        $personal_rating += 20;
    }

    if($app->datetime->getDaysDiff($user->time_create) >= 30){
        $personal_rating += 10;
    }


    if($personal_rating >= 50){
        return true;
    }

    return false;

}