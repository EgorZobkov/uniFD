public function referral()
{   

    $this->view->visible_header = false;

    $this->asset->registerJs(["view"=>"web", "name"=>"<script src=\"{assets_path}/js/profile.js\" type=\"module\" ></script>"]);

    $data = (object)[];

    if(!$this->settings->referral_program_status || !$this->settings->profile_wallet_status){
        abort(404);
    }

    if(compareValues($_GET['tab'], 'rewards')){
        $data->referrals = $this->component->profile->getAllAwardsReferrals($this->user->data->id);
    }else{
        $data->referrals = $this->component->profile->getAllUsersReferrals($this->user->data->id);
    }

    return $this->view->render('profile/referral', ["data"=>(object)$data, "seo"=>(object)["meta_title"=>translate("tr_af290a256ca664b10c4fd61c9534c635")]]);
}