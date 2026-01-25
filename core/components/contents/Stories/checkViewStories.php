public function checkViewStories($story_id=0, $user_id=0){
    global $app;

    $session_id = $app->session->get("user-session-id");

    if($user_id){
        $check = $app->model->stories_media_views->find("story_id=? and user_id=?", [$story_id,$user_id]);
    }else{
        $check = $app->model->stories_media_views->find("story_id=? and session_id=?", [$story_id,$session_id]);
    }

    if($check){
        return true;
    }

    return false;

}