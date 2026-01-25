<?php

$app->pagination->request($_POST);

$data->transactions = $app->model->transactions->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll('user_id=?', [$_POST["user_id"]]);

if($data->transactions){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span>№</span> </th>
        <th> <span><?php echo translate("tr_dfde1ffd136702faa5d88f9317918b49"); ?></span> </th>
        <th> <span><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?></span> </th>
        <th> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
        <th> <span><?php echo translate("tr_19b244e68f789a1ca79e9c9f44e7c16d"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data->transactions as $order) {

            ?>

            <tr>
              <td><?php echo $order["order_id"]; ?></td>
              <td>
                <?php 
                  echo $app->component->transaction->getTitleByTemplateAction(_json_decode(decrypt($order["data"])));
                ?>
              </td>
              <td><?php echo $app->system->amount($order["amount"]); ?></td>
              <td><?php echo $app->datetime->outDate($order["time_create"]); ?></td>
              <td>
                <?php if($order["status_payment"]){ ?>
                  <span class="badge bg-label-success me-1"><?php echo translate("tr_1ec8bd15c6af4d32aea09b6e7ad4f1f3"); ?></span>
                <?php }else{ ?>
                  <span class="badge bg-label-warning me-1"><?php echo translate("tr_f13d02b0f60cd950a9b3eada8a5de56e"); ?></span>
                <?php } ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteOrder" data-id="<?php echo $order['id']; ?>" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>

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
  echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_0158e45cd68fedea705ec3f982f0116b"), "subtitle"=>translate("tr_329cca5eed24e1d3115bf2d057634e8a")]);
}
?>