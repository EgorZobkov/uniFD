public function login()
{   

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/auth.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/auth.js\" type=\"module\" ></script>"]);

    return $this->view->render('auth', [ "title"=>translate("tr_865b129166f4e52286bb98bdc42850ef")]);

}