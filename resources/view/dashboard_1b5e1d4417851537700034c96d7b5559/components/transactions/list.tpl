<?php

$app->pagination->request($_POST);

$data = $app->model->transactions->pagination(true)->page($_POST['page'])->output($_POST['output'])->filter($_POST['filter'])->search($_POST['search'])->sort('id desc')->getAll();

if($data){

?>
<form class="formItemsList" >
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><input class="form-check-input actionAllCheckboxItems" type="checkbox" ></th>
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

        foreach ($data  as $order) {

            $order = $app->component->transaction->getData($order);

            ?>

            <tr class="transactions-tr-container" >
              <td>
                <div class="form-check">
                  <input class="form-check-input itemCheckboxItem" type="checkbox" name="ids_selected[]" value="<?php echo $order->id; ?>" >
                </div>
              </td>
              <td><?php echo $order->order_id; ?></td>
              <td>
                <?php 

                  echo $app->component->transaction->getTitleByTemplateAction(_json_decode(decrypt($order->data)));

                  if($order->item_title){
                    ?>
                    <div>
                      <?php echo translateField($order->item_title); ?>
                    </div>
                    <?php 
                  }

                  if($order->user->id){
                    ?>
                    <div>
                      <a href="<?php echo $app->router->getRoute("dashboard-user-card", [$order->user->id]); ?>"><?php echo $app->user->name($order->user,true); ?></a>
                    </div>
                    <?php 
                    
                  }

                ?>
              </td>
              <td><?php echo $app->system->amount($order->amount); ?></td>
              <td><?php echo $app->datetime->outDate($order->time_create); ?></td>
              <td>
                <?php if($order->status_payment){ ?>
                  <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_1ec8bd15c6af4d32aea09b6e7ad4f1f3"); ?></span>
                <?php }else{ ?>
                  <span class="badge rounded-pill bg-label-warning me-1"><?php echo translate("tr_f13d02b0f60cd950a9b3eada8a5de56e"); ?></span>
                <?php } ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteOrder" data-id="<?php echo $order->id; ?>" >
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
</form>
<?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["search"=>$_POST['search'], "filter"=>$_POST['filter'], "title"=>translate("tr_0158e45cd68fedea705ec3f982f0116b"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]); } ?>