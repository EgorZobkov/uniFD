public function systemReports(){

    if($this->settings->system_report_status){

        if(!$this->settings->system_report_last_time_generation){
            $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');
        }

        if($this->settings->system_report_period == 24){
            $date = $this->datetime->format("Y-m-d")->addDay(1)->getDate($this->settings->system_report_last_time_generation) . ' ' . $this->settings->system_report_send_time;
        }else{
            $date = $this->datetime->addHours($this->settings->system_report_period)->getDate($this->settings->system_report_last_time_generation);
        }

        if($this->datetime->getDate() >= $date){

            $data = $this->system->statisticReportByHours();

            if(!$this->settings->system_report_send_if_zero){

                if(!$this->system->statisticReportHasData($data)){
                    $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');
                    return;
                }

            }

            $this->model->traffic_report->truncate();
            $this->model->settings->update($this->datetime->getDate(),'system_report_last_time_generation');

            $this->notify->sendReport($data);

        }

    }      

}