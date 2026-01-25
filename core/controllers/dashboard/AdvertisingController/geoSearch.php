public function geoSearch()
{   

    return $this->component->geo->advertisingSearchCombined($_POST['query']);

}