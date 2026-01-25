public function loadDataChartMonth()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    $date = "";

    if($_POST["year"] && $_POST["month"]){
        $date = $_POST["year"]."-".$_POST["month"];
    }

    return $this->component->transaction->getStatisticsByMonthChart($date);

}