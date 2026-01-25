public function home()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/pages/dashboard.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/dashboard.js\" type=\"module\" ></script>"]);

    return $this->view->render('home', ["title"=>translate("tr_4922ea013f76c2d3622baf1f607812b6")]);

}