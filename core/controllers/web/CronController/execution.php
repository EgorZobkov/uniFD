public function execution($key=null)
{   

    if($this->config->app->private_service_key != $key){
        return false;
    }

    $getTasks = $this->model->system_cron_tasks->getAll();

    if($getTasks){
        foreach ($getTasks as $key => $value) {
            
            try {

                if($value["time_current"] >= $value["time_execution"]){

                    $this->model->system_cron_tasks->update(['time_current'=>1], $value["id"]);  
                    $this->{$value["class_name"]}();
                  
                }else{
                    $this->model->system_cron_tasks->update(['time_current'=>(int)$value["time_current"]+1], $value["id"]);
                }

            } catch (Exception $e) {
                Logger::set("Cron ".$value["class_name"]." error: {$e->getMessage()}");
            }

        }
    }

    $this->model->settings->update($this->datetime->getDate(),'crontab_time_last_execution');

}