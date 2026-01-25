<?php

$app->pagination->request($_POST);

$data = $app->model->transactions_deals->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

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

        foreach ($data as $value) {

            ?>

            <tr>
              <td><a href="<?php echo $app->router->getRoute("dashboard-deal-card", [$value['order_id']]); ?>" ><?php echo $value["order_id"]; ?></a></td>
              <td><?php echo $app->system->amount($value["amount"]); ?></td>
              <td><?php echo $app->datetime->outDate($value["time_create"]); ?></td>
              <td>
                <span class="badge rounded-pill bg-label-<?php echo $app->component->transaction->getStatusDeal($value["status_processing"])->label; ?> me-1"><?php echo $app->component->transaction->getStatusDeal($value["status_processing"])->name; ?></span>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <a class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light"  href="<?php echo $app->router->getRoute("dashboard-deal-card", [$value['order_id']]); ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </a>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteDeal" data-id="<?php echo $value['order_id']; ?>" >
                    <i class="ti ti-xs ti-trash"></i>
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "filter"=>$_POST['filter'], "title"=>translate("tr_49fba506a7b9eaaffd3d587eea1f8ba4"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]); } ?>