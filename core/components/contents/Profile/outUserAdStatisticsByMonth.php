public function outUserAdStatisticsByMonth($item_id=0, $month=null,$year=null){
    global $app;

    $result = "";

    if(!$year){
        $year = $app->datetime->format("Y")->getDate();
    }

    if(!$month){
        $month = abs($app->datetime->format("m")->getDate());
    }

    $x=0;
    while ($x++<12){

       $active = "";

       if(compareValues($year.'-'.$month, $year.'-'.$x)){
            $active = "active";
       }

       $result .= '
           <a class="transactions-statistics-month-list-item '.$active.'" href="?item_id='.$item_id.'&month='.$x.'&year='.$year.'" >
             <strong>'.$app->datetime->getCurrentNameMonth($x).', '.$year.'</strong>
           </a>
       ';

    }

    return $result;

}