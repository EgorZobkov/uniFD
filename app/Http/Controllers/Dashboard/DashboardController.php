<?php

 /**
 * UniSite CMS
 * @link https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

 namespace App\Http\Controllers\Dashboard;

 use App\Systems\Controller;

 class DashboardController extends Controller
 {

 public function __construct($app){
 parent::__construct($app); 
 }

 public function addToFavorites(){

    $find = $this->model->system_favorites->find("user_id=? and route_name=?", [$this->user->data->id,$_POST["route_name"]]);

    if($find){
        $this->model->system_favorites->delete("id=?", [$find->id]);
        return json_answer(["status"=>"delete", "favorites"=>$this->system->getSystemFavorites()]);
    }else{
        $this->model->system_favorites->insert(["user_id"=>$this->user->data->id, "route_name"=>$_POST["route_name"], "page_name"=>$_POST["page_name"], "page_icon"=>$_POST["page_icon"]]);
        return json_answer(["status"=>"added", "favorites"=>$this->system->getSystemFavorites()]);
    }

}

public function captcha()
{
    return $this->captcha->image("captcha");
}

public function captchaVerify()
{   
    $result = $this->system->captchaVerify($_POST['code'], $_POST["captcha_id"]);
    return json_answer($result);
}

public function checkFlashNotify(){   
    $notify = $this->session->getNotify("dashboard");
    if(isset($notify)){
        return _json_encode($notify);
    }
    return null;
}

public function collapsedSidebar(){

    $find = $this->model->system_customize_template->find("user_id=?", [$this->user->data->id]);

    if($find){
        $this->model->system_customize_template->update(["collapsed_sidebar"=>$_POST['status']], $find->id);
    }else{
        $this->model->system_customize_template->insert(["user_id"=>$this->user->data->id, "collapsed_sidebar"=>$_POST['status']]);
    }

    return json_answer(["status"=>true]);
}

public function customizeTemplate(){

    $find = $this->model->system_customize_template->find("user_id=?", [$this->user->data->id]);

    if($find){
        $this->model->system_customize_template->update(["theme_color"=>$_POST['template_theme_color'], "position_menu"=>$_POST['template_position_menu'], "direction"=>$_POST['template_direction'], "language"=>$_POST['template_language']], $find->id);
    }else{
        $this->model->system_customize_template->insert(["user_id"=>$this->user->data->id, "theme_color"=>$_POST['template_theme_color'], "position_menu"=>$_POST['template_position_menu'], "direction"=>$_POST['template_direction'], "language"=>$_POST['template_language']]);
    }

    if($_POST["template_home_widgets"]){

        $getUserWidgets = $this->model->system_home_users_widgets->getAll("user_id=?", [$this->user->data->id]);
        if($getUserWidgets){
            foreach ($getUserWidgets as $key => $value) {
                if(!in_array($value["widget_id"], $_POST["template_home_widgets"])){
                    $this->model->system_home_users_widgets->delete("id=?", [$value["id"]]);
                }
            }
            foreach ($_POST["template_home_widgets"] as $key => $id) {
                $findUserWidget = $this->model->system_home_users_widgets->find("user_id=? and widget_id=?", [$this->user->data->id,$id]);
                if(!$findUserWidget){
                    $findWidget = $this->model->system_home_widgets->find("id=?", [$id]);
                    $this->model->system_home_users_widgets->insert(["user_id"=>$this->user->data->id, "widget_id"=>$id, "sorting"=>$findWidget->sorting]);
                }
            }
        }else{

            if(isset($_POST["template_home_widgets"])){
                foreach ($_POST["template_home_widgets"] as $id) {
                    $findWidget = $this->model->system_home_widgets->find("id=?", [$id]);
                    $this->model->system_home_users_widgets->insert(["user_id"=>$this->user->data->id, "widget_id"=>$id, "sorting"=>$findWidget->sorting]);
                }
            }           

        }

    }else{
        $this->model->system_home_users_widgets->delete("user_id=?", [$this->user->data->id]);
    }

    return json_answer(["status"=>true]);

}

public function deleteFavorite(){

    $this->model->system_favorites->delete("user_id=? and id=?", [$this->user->data->id,$_POST["id"]]);

    return json_answer(["favorites"=>$this->system->getSystemFavorites()]);

}

public function home()
{   

    if(!$this->user->verificationAccess('view')->status){
        return $this->view->accessDenied();
    }

    $this->asset->registerCss(["view"=>"dashboard", "name"=>"<link rel=\"stylesheet\" href=\"{assets_path}/css/pages/dashboard.css\" />"]);
    $this->asset->registerJs(["view"=>"dashboard", "name"=>"<script src=\"{assets_path}/js/pages/dashboard.js\" type=\"module\" ></script>"]);

    return $this->view->render('home', ["title"=>translate("tr_4922ea013f76c2d3622baf1f607812b6")]);

}

public function homeUpdate()
{   

    $content = [];
    $getUserWidgets = $this->model->system_home_users_widgets->sort("sorting asc")->getAll("user_id=?", [$this->user->data->id]);
    if($getUserWidgets){
        foreach ($getUserWidgets as $key => $value) {
            $widget = $this->model->system_home_widgets->find("id=?", [$value["widget_id"]]);
            $data = $this->view->setParamsComponent(['data'=>(object)$value, 'widget'=>$widget])->includeComponent("home/widgets/{$widget->template_name}.tpl");
            $content[$value["id"]] = ["hash"=>hash('sha256', $data), "data"=>$data];
        }
    }

    return json_answer($content);

}

public function search(){

    $result = $this->system->searchCombined($_POST["query"]);
    return json_answer($result);

}

public function translite(){
    return json_answer(["result"=>slug($_POST['text'])]);
}

public function widgetRemove(){

    $this->model->system_home_users_widgets->delete("id=? and user_id=?", [$_POST["id"],$this->user->data->id]);

    return json_answer(["status"=>true]);

}

public function widgetsSorting(){

    if($_POST["ids"]){
        foreach (explode(",", $_POST["ids"]) as $key => $id) {
            $this->model->system_home_users_widgets->update(["sorting"=>$key], $id);
        }
    }

    return json_answer(["status"=>true]);

}



 }