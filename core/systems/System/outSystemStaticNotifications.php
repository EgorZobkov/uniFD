public function outSystemStaticNotifications($notification=null){
    global $app;

    $answer = '';

    if(isset($notification)){

        if($notification == "cron"){

            if (!$app->settings->crontab_time_last_execution) {
                return '
                  <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <span class="alert-icon text-warning me-2">
                      <i class="ti ti-bell ti-xs"></i>
                    </span>
                    '.translate("tr_9c11ff8889b148b39ac4223a33d884c5").'
                  </div>                    
                ';                    
            }

        }

    }

}