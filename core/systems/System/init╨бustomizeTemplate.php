public function initСustomizeTemplate(){
    global $app;

    if($this->getSystemTemplate()->theme_color == 'dark'){

        if($this->getSystemTemplate()->direction == 'rtl'){
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/core-dark.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/theme-default-dark.css\" />"]);
        }else{
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/core-dark.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/theme-default-dark.css\" />"]);
        }

    }else{

        if($this->getSystemTemplate()->direction == 'rtl'){
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/core.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/rtl/theme-default.css\" />"]);
        }else{
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/core.css\" />"]);
            $app->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/theme-default.css\" />"]);
        }

    }

}