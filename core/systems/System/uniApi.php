function uniApi($action=null, $params=[]){
    global $app;

    $params["action"] = $action;
    $params["token"] = $app->settings->uniid_token;
    $params["domain"] = getHost(false);
    $params["version"] = $app->settings->system_version;
    $params["lang"] = $app->system->getSystemTemplate()->language;
    
    $url = http_build_query($params);

    return _json_decode(_file_get_contents("{$app->settings->uni_api_link}/api.php?".$url));

}