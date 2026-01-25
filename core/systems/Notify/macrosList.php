public function macrosList(){
    global $app;

    $geo = getGeolocation();

    return [
        "{domain}"=>getHost(true),
        "{city}"=>$geo["city"],
        "{ip}"=>getIp(),
        "{project_name}"=>$app->settings->project_name,
        "{project_title}"=>$app->settings->project_title,
        "{dashboard_link}"=>getUrlDashboard(),
        "{logo}"=>$app->storage->host(true)->logo(),
        "{logo_mini}"=>$app->storage->host(true)->logoMini(),
    ];
    
}