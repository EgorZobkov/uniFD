public function create(){   

    $this->view->visible_header = false;
    $this->view->visible_footer = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/ad.js\" type=\"module\" ></script>"]);
    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/vendors/minicolors/jquery.minicolors.min.js\" ></script>"]);
    $this->asset->registerCss(["view"=>"web", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/vendors/minicolors/jquery.minicolors.css\" />"]);

    $seo = $this->component->seo->content();

    return $this->view->render('ad-create', ["seo"=>$seo]);
}