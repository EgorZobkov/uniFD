public function getStatisticsInstallByMonthChart($filter_date=null){   
    global $app;

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

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

        $totalCount = $app->model->mobile_stat->count("date(time_create)=?", [$date]);

        $action_count[translate("tr_268c84614442059ed8301431b06778f3")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>(int)$totalCount];

    }

    foreach ($action_count as $action => $nested) {
        $data = [];
        foreach ($nested as $key => $value) {
            $data[] = ["x"=>$value["date"], "y"=>$value["count"]];
        }
        $series[] = ["name"=>$action, "data"=>$data];
    }

    return $series;
}