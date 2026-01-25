public function loadDataChartWeekAndMonth()
{

    return ["week"=>$this->component->users->getTotalUsersByWeekChart(), "month"=>$this->component->users->getStatisticsUsersByMonthChart()];

}