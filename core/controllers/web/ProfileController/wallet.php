public function wallet()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    if(!$this->settings->profile_wallet_status){
        abort(404);
    }

    $data = (object)[];

    $data->history = $this->component->profile->outPaymentHistoryWallet();

    return $this->view->render('profile/wallet', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_419a0c4f19223bbef8fd1cbf92bf0cd0")]]);
}