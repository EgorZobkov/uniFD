public function saveGraphics()
{   

    if(!$this->user->verificationAccess('control')->status){
        return json_answer(["access"=>false]);
    }

    $answer = [];

    $_POST["watermark_title_opacity"] = intval($_POST["watermark_title_opacity"]) < 0 || intval($_POST["watermark_title_opacity"]) > 100 ? 80 : intval($_POST["watermark_title_opacity"]);
    $_POST["watermark_title"] = trimStr($_POST["watermark_title"], 50);

    if($_POST["watermark_image_percent_size"] > 100){
        $_POST["watermark_image_percent_size"] = 100;
    }

    if($_POST["watermark_image_opacity"] > 100){
        $_POST["watermark_image_opacity"] = 100;
    }

    if($_POST["watermark_type"] == "title"){
        if($this->validation->requiredField($_POST['watermark_title'])->status == false){
            $answer['watermark_title'] = $this->validation->error;
        }
    }elseif($_POST["watermark_type"] == "image"){
        if($this->validation->requiredField($_POST['watermark_image'])->status == false){
            $answer['watermark_image'] = $this->validation->error;
        }
    }

    if(empty($answer)){

        $this->model->settings->update($_POST['logo_main']?:null,"logo_main");
        $this->model->settings->update($_POST['logo_emblem']?:null,"logo_emblem");
        $this->model->settings->update($_POST['favicon']?:null,"favicon");

        $this->model->settings->update($_POST["watermark_status"],"watermark_status");
        $this->model->settings->update($_POST["watermark_type"],"watermark_type");
        $this->model->settings->update($_POST["watermark_title"],"watermark_title");
        $this->model->settings->update($_POST["watermark_title_font"],"watermark_title_font");
        $this->model->settings->update($_POST["watermark_title_size"],"watermark_title_size");
        $this->model->settings->update($_POST["watermark_title_opacity"],"watermark_title_opacity");
        $this->model->settings->update($_POST["watermark_image_position"],"watermark_image_position");
        $this->model->settings->update(abs($_POST["watermark_image_percent_size"]),"watermark_image_percent_size");
        $this->model->settings->update(abs($_POST["watermark_image_opacity"]),"watermark_image_opacity");
        $this->model->settings->update($_POST['watermark_image']?:null,"watermark_image");

        return json_answer(["status"=>true, "type_show"=>"notice", "type_answer"=>"success", "answer"=>code_answer("save_successfully")]);

    }else{
        return json_answer(["status"=>false, "type_show"=>"form", "type_answer"=>"error", "answer"=>$answer]);
    }

}