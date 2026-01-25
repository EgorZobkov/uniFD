<?php

$data->sessions = $app->model->auth->sort("time_expiration desc")->getAll("user_id=?", [$_POST["user_id"]]);

if($data->sessions){

?>

<div class="table-responsive">
  <table class="table border-top">
    <thead>
      <tr>
        <th class="text-truncate"> <span><?php echo translate("tr_72275dacae2e3cdbe1c33d46e0dcc0d4"); ?></span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_dd286747571a747d8d43c0a94986bef3"); ?></span> </th>
        <th class="text-truncate"> <span>IP</span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_5192bdb7a058b0b2f9272d8696050d12"); ?></span> </th>
        <th class="text-truncate"></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

    <?php
    foreach ($data->sessions as $key => $value) {

       $value["geo"] = _json_decode($value["geo"]);

       ?>

        <tr>
          <td class="text-truncate"><?php echo deviceDetect($value["user_agent"], $value["device_model"]) ?: '-'; ?></td>
          <td class="text-truncate"><?php echo browserDetect($value["user_agent"]) ? browserDetect($value["user_agent"])->name : '-'; ?></td>
          <td class="text-truncate"><a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></td>
          <td class="text-truncate"><?php echo $app->datetime->outDateTime($value["time_expiration"]); ?></td>
          <td class="text-truncate text-end">
            <?php if($app->user->setUserId($value["user_id"])->verificationAccess('control')->status){ ?>
            <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteAuthSessionUser" data-auth-id="<?php echo $value["id"]; ?>" data-user-id="<?php echo $value["user_id"]; ?>" >
              <span class="ti ti-xs ti-trash"></span>
            </button> 
            <?php } ?>               
          </td>
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