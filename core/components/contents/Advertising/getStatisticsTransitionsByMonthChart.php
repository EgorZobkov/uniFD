public function getStatisticsTransitionsByMonthChart(){   
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

    $getAdvertising = $app->model->advertising->getAll();

    foreach ($dates as $date) {

        foreach ($getAdvertising as $key => $value) {

            $getCount = $app->model->advertising_transitions->count("date(time_create)=? and advertising_id=?", [$date,$value["id"]]);

            if($getCount){
                $action_amount[translateField($value["name"])][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>$getCount, "title"=>$getCount.' '.endingWord($getCount, translate("tr_20b4dec10798ad185565ff7941c651da"),translate("tr_3fa7d89fb89054493d81a6d175ec141e"),translate("tr_9ac96ada273b88026b753b7d2403b601"))]; 
            }else{
                $action_amount[translateField($value["name"])][] = ["date"=>date("d.M.Y", strtotime($date)), "count"=>0, "title"=>'0 '.translate("tr_9ac96ada273b88026b753b7d2403b601")];
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