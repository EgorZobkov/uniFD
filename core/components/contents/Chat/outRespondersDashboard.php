public function outRespondersDashboard(){
     global $app;

     $responders = $app->model->chat_responders->sort("id desc")->getAll("status=?", [0]);

     if($responders){
        foreach ($responders as $value) {
            ?>
              <div class="chat-sidebar-list-item loadEditResponder" data-id="<?php echo $value["id"]; ?>" >
                <div class="chat-sidebar-list-item-status" > <i class="ti ti-clock-hour-3"></i> </div>
                <div class="chat-sidebar-list-item-name" >
                    <strong><?php echo $value["name"]; ?></strong>
                    <div>
                    <?php
                        if($value["send"] == "now"){
                           echo '<small>'.translate("tr_848a83b00a92e5664b4af49d35661a50").'</small>';
                        }else{
                           if($app->datetime->currentTime() >= strtotime($value["time_send"])){
                                echo '<small>'.translate("tr_848a83b00a92e5664b4af49d35661a50").'</small>';
                           }else{
                                echo '<small>'.translate("tr_c31513e639b7c5d1a31ac47f7212b7bd").' '.$app->datetime->outStringDiff(null,$value["time_send"]).'</small>';
                           }
                        }
                    ?>
                    </div>
                </div>
              </div>
            <?php
        }
     }

}