public function loadDataChartWeekAndMonth()
{

    if(!$this->user->verificationAccess('view')->status){
        return json_answer(["access"=>false]);
    }

    return ["week"=>$this->component->transaction->getTotalTransactionsByWeekChart(), "month"=>$this->component->transaction->getStatisticsByMonthChart()];

}