<?php

$data = $app->model->mobile_stat->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort("time_update desc")->getAll();

if($data){

?>

<div class="table-responsive">
  <table class="table border-top">
    <thead>
      <tr>
        <th class="text-truncate"> <span><?php echo translate("tr_72275dacae2e3cdbe1c33d46e0dcc0d4"); ?></span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span> </th>
        <th class="text-truncate"> <span>IP</span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

    <?php
    foreach ($data as $key => $value) {

       $user = [];

       if($value["user_id"]){
          $user = $app->model->users->find("id=?", [$value["user_id"]]);
       }

       if($value["device_platform"] == "Android"){
         $device_platform = '<i class="icon-base ti ti-brand-android ti-sm icon-lg text-heading"></i>';
       }elseif($value["device_platform"] == "iOS"){
         $device_platform = '<i class="icon-base ti ti-brand-apple ti-sm icon-lg text-heading"></i>';
       }else{
         $device_platform = '<i class="icon-base ti ti-question-mark ti-sm icon-lg text-heading"></i>';
       }

       ?>
        <tr>
          <td class="text-truncate"><?php echo $device_platform; ?> <?php echo $value["device_model"]; ?></td>
          <td class="text-truncate">
          <?php if($user){ ?>
                <div class="d-flex justify-content-left align-items-center">
                  <div class="avatar-wrapper">
                    <div class="avatar me-3"><img src="<?php echo $app->storage->name($user->avatar)->get(); ?>" class="image-autofocus rounded-circle"></div>
                  </div>
                  <div class="d-flex flex-column">
                    <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$user->id]); ?>" class="text-body text-truncate">
                      <span class="fw-medium"><?php echo $app->user->name($user,true); ?></span>
                    </a>
                  </div>
                </div>
          <?php }else{ echo '-'; } ?>
          </td>
          <td class="text-truncate"><a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></td>
          <td><?php echo $app->datetime->outDateTime($value['time_update']); ?></td>
        </tr>

       <?php
    }
    ?>      
      
    </tbody>
  </table>
</div>

<?php

}else{

  echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_26254ca95ba8d208a1674e9b23653d50"), "subtitle"=>translate("tr_76ab830d26443c3b2cd6d516d8ece454")]);

}
?>