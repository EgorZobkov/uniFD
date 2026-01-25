public function getTotalTransactionsByWeekChart(){   
    global $app;

    $data = [];

    $week[date('Y-m-d')] = date('Y-m-d');

    $currentWeek = date("w",strtotime(date('Y-m-d'))) == 0 ? 7 : date("w",strtotime(date('Y-m-d')));

    if($currentWeek > 1){
        $x=0;
        while ($x++<$currentWeek-1){
           $week[date('Y-m-d', strtotime("-".$x." day"))] = date('Y-m-d', strtotime("-".$x." day"));
        }
    }

    foreach ($week as $key => $value) {
        $amount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=?", [$value]);
        $transactions = $app->model->transactions->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$amount, "title"=>$transactions.' '.endingWord($transactions, translate("tr_5505ce1e01182edbf4e8ef3638b1631e"), translate("tr_8c14745067431da281031a1e21649392"), translate("tr_042fb80f900c76e57c54ee46b36f9ac0"))." ".translate("tr_01340e1c32e59182483cfaae52f5206f")." ".$app->system->amount($amount)];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}