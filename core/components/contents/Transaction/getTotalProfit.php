public function getTotalProfit(){   
    global $app;

    $total = $app->db->getSumByTotal("amount", "uni_transactions", "status_payment=?", [1]);
    return $app->system->amount($total);

}