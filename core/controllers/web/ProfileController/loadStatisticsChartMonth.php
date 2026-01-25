public function loadStatisticsChartMonth()
{

    return $this->component->profile->getStatisticsChartMonth($_POST['item_id'], $_POST['month'], $_POST['year'], $this->user->data->id);

}