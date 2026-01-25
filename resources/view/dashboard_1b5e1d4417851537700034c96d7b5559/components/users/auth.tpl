<?php

$data->auth = $app->model->auth_sessions->sort("time_create desc")->getAll("user_id=?", [$_POST["user_id"]]);

if($data->auth){

?>

<div class="table-responsive">
  <table class="table border-top">
    <thead>
      <tr>
        <th class="text-truncate"> <span><?php echo translate("tr_72275dacae2e3cdbe1c33d46e0dcc0d4"); ?></span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_dd286747571a747d8d43c0a94986bef3"); ?></span> </th>
        <th class="text-truncate"> <span>IP</span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_586844a8461cae86c37feaadf489fbad"); ?></span> </th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

     <?php
      foreach ($data->auth as $key => $value) {

         $value["geo"] = _json_decode($value["geo"]);

         ?>

          <tr>
            <td class="text-truncate"><?php echo deviceDetect($value["user_agent"], $value["device_model"]) ?: '-'; ?></td>
            <td class="text-truncate"><?php echo browserDetect($value["user_agent"]) ? browserDetect($value["user_agent"])->name : '-'; ?></td>
            <td class="text-truncate"><a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></td>
            <td class="text-truncate"><?php echo $app->datetime->outDateTime($value["time_create"]); ?></td>
          </tr>

         <?php
      }
     ?>
      
    </tbody>
  </table>
</div>

<?php

}else{
  ?>
  <div class="card-body" >
    <?php echo $app->ui->wrapperInfo("dashboard-no-data"); ?>
  </div>
  <?php
}
?> 