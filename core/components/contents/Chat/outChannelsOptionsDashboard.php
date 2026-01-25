public function outChannelsOptionsDashboard($ids=[]){
     global $app;

     $channels = $app->model->chat_channels->sort("id desc")->getAll("status=?", [1]);

     if($channels){
        foreach ($channels as $value) {

            if(compareValues($ids, $value["id"])){
                ?>
                <option value="<?php echo $value["id"]; ?>" selected="" ><?php echo $value["name"]; ?></option>
                <?php
            }else{
                ?>
                <option value="<?php echo $value["id"]; ?>" ><?php echo $value["name"]; ?></option>
                <?php
            }

        }
     }

}