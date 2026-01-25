public function getStatisticsChartMonth($item_id=0, $month=null, $year=null, $user_id=0, $date_format=null){   
    global $app;

    $ad = $app->model->ads_data->find("id=? and user_id=?", [$item_id, $user_id]);

    if(!$ad){
        return [];
    }

    $actions = $this->actionsCode();

    if(!$ad->partner_link){
        unset($actions["go_partner_link"]);
    }

    $series = [];
    $dates = [];
    $data = [];
    $action_count = [];

    $y = !$year ? $app->datetime->format("Y")->getDate() : $year;
    $m = !$month ? $app->datetime->format("m")->getDate() : $month;            

    $days_in_month = $app->datetime->daysInMonth($m, $y);

    $x=0;
    while ($x++<$days_in_month){
       $dates[$y."-".$m."-".$x] = $y."-".$m."-".$x;
    }

    foreach ($dates as $date) {

        foreach ($actions as $value) {

            $count = $app->model->users_actions->count("date(time_create)=? and action_code=? and item_id=?", [$date,$value["code"],$item_id]);

            if($count){
                $action_count[$value["name_declension"]][] = ["date"=>date($date_format ?: "d.M.Y", strtotime($date)), "count"=>$count]; 
            }else{
                $action_count[$value["name_declension"]][] = ["date"=>date($date_format ?: "d.M.Y", strtotime($date)), "count"=>0];
            }

        }

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