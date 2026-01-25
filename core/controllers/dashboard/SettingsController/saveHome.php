public function saveHome()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    if($_POST["out_default_count_items_home"] > 1000){
        $_POST["out_default_count_items_home"] = 1000;
    }

    if($_POST["frontend_home_visible_widgets"]){
        $key = 1;
        foreach ($_POST["frontend_home_visible_widgets"] as $code => $value) {
            $this->model->frontend_home_widgets->update(["sorting"=>$key, "status"=>$_POST["frontend_home_visible_widgets_active"][$code] ? 1 : 0], ["code=?", [$code]]);
            $key++;
        }
    }

    $this->model->settings->update(_json_encode($_POST["frontend_home_slider_categories_ids"]),"frontend_home_slider_categories_ids");
    $this->model->settings->update($_POST["out_default_count_items_home"],"out_default_count_items_home");

    return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

}