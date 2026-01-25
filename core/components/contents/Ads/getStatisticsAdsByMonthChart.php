public function getStatisticsAdsByMonthChart(){   
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

        $totalCount = $app->model->ads_data->count("date(time_create)=?", [$date]);

        $action_count[translate("tr_1ad572680550ba922398bc5c7b049ba3")][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>(int)$totalCount];

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