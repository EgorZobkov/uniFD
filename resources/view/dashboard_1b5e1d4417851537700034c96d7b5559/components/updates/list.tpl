<?php

$data = $app->model->system_updates->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_37252115f0160d8a655c14f8cbe8127e"); ?></span></th>
        <th><span><?php echo translate("tr_f15b55777d025acb538d1a65aff19855"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            ?>
            <tr>
              <td>
                  <?php echo $value['version']; ?>
              </td>
              <td><?php echo $app->datetime->outDateTime($value['time_create']); ?></td>
              <td>
                <span class="badge rounded-pill bg-label-success"><?php echo translate("tr_094f5d3da6323c6ea33538de2e2c5938"); ?></span>
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
   echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_60ef1e001c00f0001a8472bda0ee9ec1"), "subtitle"=>translate("tr_1b81f036f3378b9d9687544a47c7355a")]);
}
?>