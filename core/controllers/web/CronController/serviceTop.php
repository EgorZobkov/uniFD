public function serviceTop(){

    if($this->settings->out_default_count_items){
        $this->model->ads_data->updateQuery("time_sorting=? where service_top_status=? order by count_display asc limit ?", [$this->datetime->getDate(),1,$this->settings->out_default_count_items]);
    }

}