public function searchCombined()
{   

    return $this->component->geo->searchCombined($_POST['query'], $_POST['country_id']);

}