public function outStatisticsListProfitByMonth($month=null,$year=null){
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

       $getAmount = $app->db->getSumByTotal("amount", "uni_transactions", "year(time_create)=? and month(time_create)=? and status_payment=?", [$year,$x,1]);

       $result .= '
           <a class="transactions-statistics-month-list-item '.$active.'" href="?month='.$x.'&year='.$year.'" >
             <strong>'.$app->datetime->getCurrentNameMonth($x).', '.$year.'</strong>
             <span>'.$app->system->amount($getAmount).'</span>
           </a>
       ';

    }

    return $result;

}