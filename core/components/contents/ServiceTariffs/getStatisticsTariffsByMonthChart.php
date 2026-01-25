public function getStatisticsTariffsByMonthChart(){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_amount = [];

    $y = $app->datetime->format("Y")->getDate();
    $m = $app->datetime->format("m")->getDate();            

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    $getTariffs = $app->model->users_tariffs->getAll();

    foreach ($dates as $date) {

        foreach ($getTariffs as $key => $value) {

            $getCount = $app->model->transactions->count("date(time_create)=? and tariff_id=?", [$date,$value["id"]]);
            $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=? and tariff_id=?", [$date,$value["id"]]);

            if($getCount){
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$getCount, "title"=>$getCount.' '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount($getAmount)]; 
            }else{
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>0, "title"=>'0 '.translate("tr_01340e1c32e59182483cfaae52f5206f").' '.$app->system->amount(0)];
            }

        }

    }

    foreach ($action_amount as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"], "title"=>$value["title"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}