public function statistics()
{   

    $this->view->visible_header = false;

    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/apexcharts/apexcharts.css\" />"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/apexcharts/apexcharts.min.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];
    
    return $this->view->render('profile/statistics', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_a62b9e5890d76fe02b0c809915136afd")]]);
}