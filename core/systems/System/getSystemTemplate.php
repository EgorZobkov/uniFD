public function getSystemTemplate(){
    global $app;

    if($app->user->data->customize_template){
        $app->user->data->customize_template->theme_color = $app->user->data->customize_template->theme_color?:$app->settings->system_default_template_theme_color;
        $app->user->data->customize_template->position_menu = $app->user->data->customize_template->position_menu?:$app->settings->system_default_template_position_menu;
        $app->user->data->customize_template->direction = $app->user->data->customize_template->direction?:$app->settings->system_default_template_direction;
        $app->user->data->customize_template->language = $app->user->data->customize_template->language?:$app->settings->default_language;
        $app->user->data->customize_template->collapsed_sidebar = $app->user->data->customize_template->collapsed_sidebar ? true : false;
        return $app->user->data->customize_template;
    }
     
    return (object)["theme_color"=>$app->settings->system_default_template_theme_color, "position_menu"=>$app->settings->system_default_template_position_menu, "direction"=>$app->settings->system_default_template_direction, "language"=>$app->settings->default_language, "collapsed_sidebar"=>true];

}