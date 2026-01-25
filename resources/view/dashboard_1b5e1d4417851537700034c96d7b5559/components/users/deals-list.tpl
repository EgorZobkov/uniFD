<?php

$app->pagination->request($_POST);

$data->deals = $app->model->transactions_deals->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll('from_user_id=? or whom_user_id=?', [$_POST["user_id"],$_POST["user_id"]]);

if($data->deals){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span>№</span> </th>
        <th> <span><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?></span> </th>
        <th> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data->deals as $order) {

            ?>

            <tr>
              <td><a href="<?php echo $app->router->getRoute("dashboard-deal-card", [$order['order_id']]); ?>" ><?php echo $order["order_id"]; ?></a></td>
              <td><?php echo $app->system->amount($order["amount"]); ?></td>
              <td><?php echo $app->datetime->outDate($order["time_create"]); ?></td>
              <td>
                <span class="badge rounded-pill bg-label-<?php echo $app->component->transaction->getStatusDeal($order["status_processing"])->label; ?> me-1"><?php echo $app->component->transaction->getStatusDeal($order["status_processing"])->name; ?></span>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteDeal" data-id="<?php echo $order["order_id"]; ?>" >
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
  echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_e9099e0680afeaa07af838752381760f"), "subtitle"=>translate("tr_329cca5eed24e1d3115bf2d057634e8a")]);
}
?>