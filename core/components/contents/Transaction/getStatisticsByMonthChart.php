public function getStatisticsByMonthChart($filter_date=null){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_amount = [];

    if($filter_date){
        $y = date("Y", strtotime($filter_date));
        $m = date("m", strtotime($filter_date));  
    }else{
        $y = $app->datetime->format("Y")->getDate();
        $m = $app->datetime->format("m")->getDate();            
    }

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        foreach ($this->actionsCode() as $value) {

            $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "date(time_create)=? and action_code=?", [$date,$value["code"]]);

            if($getAmount){
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "amount"=>$getAmount]; 
            }else{
                $action_amount[$value["name"]][] = ["date"=>date("d.M.Y", strtotime($date)), "amount"=>0];
            }

        }

    }

    foreach ($action_amount as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["amount"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}