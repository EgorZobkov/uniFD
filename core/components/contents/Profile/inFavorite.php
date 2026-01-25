public function inFavorite($ad_id=0, $user_id=0){   
    global $app;
    
    return $app->model->users_favorites->find("ad_id=? and user_id=?", [$ad_id, $user_id]) ? true : false;

}