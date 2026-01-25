public function getTotalInstallByWeekChart(){   
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
        $count = $app->model->mobile_stat->count("date(time_create)=?", [$value]);
        $data[$value] = ["x"=>$app->datetime->getNameDayWeek($value, true),"y"=>$count, "title"=>$count.' '.endingWord($count, translate("tr_ab8ae40ed581a0f7351007933de08729"), translate("tr_25273d0cf4eaea6ebc552ce62053d6f5"), translate("tr_b9e0be33837ac2d6468a62bd6cbf05d4"))];
    }

    ksort($data);

    $data = array_values($data);

    return $data;
}