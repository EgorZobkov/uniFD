<?php

$data = $app->model->traffic_realtime->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort("time_update desc")->getAll();

if($data){

?>

<div class="table-responsive">
  <table class="table border-top">
    <thead>
      <tr>
        <th class="text-truncate"> <span><?php echo translate("tr_dd286747571a747d8d43c0a94986bef3"); ?></span> </th>
        <th class="text-truncate"> <span><?php echo translate("tr_72275dacae2e3cdbe1c33d46e0dcc0d4"); ?></span> </th>
        <th class="text-truncate"> <span>URI</span> </th>
        <th class="text-truncate"> <span>referer</span> </th>
        <th class="text-truncate"> <span>IP</span> </th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

    <?php
    foreach ($data as $key => $value) {
       ?>

        <tr>
          <td class="text-truncate">
            <span class="fw-medium"><?php echo browserDetect($value["user_agent"])->name ?: '-'; ?></span>
          </td>
          <td class="text-truncate"><?php echo deviceDetect($value["user_agent"]) ?: '-'; ?></td>
          <td class="text-truncate"><a href="<?php echo getHost(true).'/'.$value["uri"]; ?>" target="_blank" ><?php echo trimStr(getHost(true).'/'.$value["uri"], 60, true); ?></a></td>
          <td class="text-truncate">
            <?php echo $value["referer"] ? '<a href="'.$app->system->uniDisguiseLink($value["referer"]).'" target="_blank" >'.trimStr($value["referer"], 60, true).'</a>' : '-'; ?>
          </td>
          <td class="text-truncate"><a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></td>
        </tr>

       <?php
    }
    ?>      
      
    </tbody>
  </table>
</div>

<?php

}else{

  echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_14b783b4a0148bbb87dc79bd7795dc24"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]);

}
?>