public function getTotalUsersByWeekChart(){   
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
        $count = $app->model->users->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$count, "title"=>$count.' '.endingWord($count, translate("tr_1075de897df42cd76107c5e32827ef92"), translate("tr_10837c2e8c09a894e000ed95430024dc"), translate("tr_11e586d97e9b7fc95413e27878a89692"))];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}