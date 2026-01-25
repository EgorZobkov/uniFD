public function verification()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->verification_users_status){
        abort(404);
    }

    if(!$this->session->get("user-verification-code")){
        $this->session->set("user-verification-code", mt_rand(1000000,9000000));
    }

    $data->uniq_code = $this->session->get("user-verification-code");
    $data->verification = $this->model->users_verifications->find("user_id=?", [$this->user->data->id]) ?: null;

    return $this->view->render('profile/verification', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_c7cadea1c393b4b40ed898d48f10c1b0")]]);
}