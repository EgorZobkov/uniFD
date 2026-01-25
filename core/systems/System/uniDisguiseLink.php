public function uniDisguiseLink($link=null){
    global $app;
    return "{$app->settings->uni_api_link}/disguiseLink.php?link=".urlencode($link);
}