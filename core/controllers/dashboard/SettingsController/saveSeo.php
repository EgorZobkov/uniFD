public function saveSeo()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $content_robots = '';

    $content_robots = "User-agent: *\n";

    if(!$_POST["seo_robots_index_status"]){
       $content_robots .= "Disallow: /\n";
    }
   
    $content_robots .= "Host: " . getHost() . "\n";
    $content_robots .= "Sitemap: " . getHost() . "/sitemap.xml\n";

    $content_robots .= "Disallow: /?*\n";

    file_put_contents(BASE_PATH . "/robots.txt", $_POST["seo_robots_manual"] ? $_POST["seo_robots_data"] : $content_robots);

    $this->model->settings->update(_json_encode($_POST["seo_sitemap_output"]),"seo_sitemap_output");
    $this->model->settings->update($_POST["seo_robots_index_status"],"seo_robots_index_status");
    $this->model->settings->update($_POST["seo_robots_manual"],"seo_robots_manual");
    $this->model->settings->update($_POST["seo_robots_manual"] ? $_POST["seo_robots_data"] : $content_robots,"seo_robots_data");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}