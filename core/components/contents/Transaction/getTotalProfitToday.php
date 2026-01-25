public function getTotalProfitToday(){   
    global $app;

    $total = $app->db->getSumByTotal("amount", "uni_transactions", "status_payment=? and date(time_create) = date(now())", [1]);
    return $app->system->amount($total);

}