public function loadDataChartWeekAndMonth()
{

    return json_answer(["week"=>$this->api->getTotalInstallByWeekChart(), "month"=>$this->api->getStatisticsInstallByMonthChart()]);

}