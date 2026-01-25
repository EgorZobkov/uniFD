public function totalAwardReferral($user_id=0){
    global $app;
    $total = $app->db->getSumByTotal("amount", "uni_users_referral_award", "whom_user_id=?", [$user_id]);
    return $app->system->amount($total);
}