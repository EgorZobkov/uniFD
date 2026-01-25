public function forgot()
{

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/auth.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/auth.js\" type=\"module\" ></script>"]);

    return $this->view->render('forgot', ["title"=>translate("tr_f490b86156968b0c43cbf28feefacd33")]);

}