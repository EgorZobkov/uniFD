public function getSystemNotifyList($user_id=0){
    global $app;

    $list = [];

    if($user_id){
        $getNotify = $app->model->users_notify_list->getAll("user_id=?", [$user_id]);
        if($getNotify){
            foreach ($getNotify as $key => $value) {
                $list[] = $value["action_code"];
            }
        }
    }

    $getNotifyList = $app->notify->actionsCodeSystem();

    if($getNotifyList){
      foreach ($getNotifyList as $value) {
        ?>
        <option value="<?php echo $value["code"]; ?>" <?php if(compareValues($list, $value["code"])){ echo 'selected=""'; } ?> ><?php echo $value["name"]; ?></option>
        <?php
      }
    }

}