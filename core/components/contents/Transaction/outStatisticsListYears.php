public function outStatisticsListYears($year=null){
    global $app;

    $result = "";

    $x=2015;
    while ($x++<2050){

       $result .= '
          <li>
            <a class="dropdown-item" href="'.requestBuildVars(["month"=>abs($app->datetime->format("m")->getDate()),"year"=>$x]).'" >
              <span>'.$x.'</span>
            </a>
          </li>
       ';

    }

    return $result;

}