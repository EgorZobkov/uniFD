<?php

$app->pagination->request($_POST);

$data = $app->model->transactions_operations->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span>№</span> </th>
        <th> <span><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?></span> </th>
        <th> <span><?php echo translate("tr_06af7dd185e713d01d1ec6fe109f6024"); ?></span> </th>
        <th> <span><?php echo translate("tr_f154d6cc8945d799f4b31ccc1e0019f5"); ?></span> </th>
        <th> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            $value = $app->component->transaction->getDataOperationByValue($value);

            ?>

            <tr>
              <td><?php echo $value->order_id; ?></td>
              <td><?php echo $app->system->amount($value->amount); ?></td>
              <td><?php echo $value->service_payment->name; ?></td>
              <td> <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$value->user->id]); ?>"><?php echo $app->user->name($value->user,true); ?></a> </td>
              <td><?php echo $app->datetime->outDateTime($value->time_create); ?></td>
              <td>
                <span class="badge rounded-pill bg-label-<?php echo $app->component->transaction->getStatusOperation($value->status_processing)->label; ?>"><?php echo $app->component->transaction->getStatusOperation($value->status_processing)->name; ?></span>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadCardOperation" data-id="<?php echo $value->id; ?>" >
                    <i class="ti ti-xs ti-eye"></i>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteOperation" data-id="<?php echo $value->id; ?>" >
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
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "filter"=>$_POST['filter'], "title"=>translate("tr_97f2b4aeffb6b44ded0155d936cce0f3"), "subtitle"=>translate("tr_6df601a7a7e5d425cecdacf9aa323f3a")]); } ?>