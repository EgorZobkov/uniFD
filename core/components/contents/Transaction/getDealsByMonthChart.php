public function getDealsByMonthChart(){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    $y = $app->datetime->format("Y")->getDate();
    $m = $app->datetime->format("m")->getDate();

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        $totalCount = $app->model->transactions_deals->count("date(time_create)=?", [$date]);
        $getAmount = $app->db->getSumByTotal("amount", "uni_transactions_deals", "date(time_create)=?", [$date]);

        $action_count[translate("tr_a2cd08bbbe3c1bea939897a780561a1c")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$totalCount, "title"=>$totalCount.' '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount($getAmount)];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"], "title"=>$value["title"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}