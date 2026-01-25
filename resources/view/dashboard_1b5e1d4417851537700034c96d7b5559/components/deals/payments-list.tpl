<?php if($data->payments){ ?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th> <span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span> </th>
        <th> <span><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?></span> </th>
        <th> <span><?php echo translate("tr_8cdd8bb771bcf038dfb2740fd50b332c"); ?></span> </th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php foreach ($data->payments as $payment){ ?>

          <tr>
            <td><span class="badge rounded-pill bg-label-<?php echo $app->component->transaction->getStatusDealPayment($payment['status_processing'])->label; ?>"><?php echo $app->component->transaction->getStatusDealPayment($payment['status_processing'])->name; ?></span></td>
            <td><?php echo $app->system->amount($payment['amount']); ?></td>
            <td><?php echo $app->datetime->outDateTime($payment['time_create']); ?></td>
            <td class="text-end" >

              <div class="flex-column flex-md-row align-items-center text-end">

                <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadPaymentCard" data-id="<?php echo $payment['id']; ?>" >
                  <i class="ti ti-xs ti-eye"></i>
                </button>

              </div>

            </td>
          </tr>

      <?php } ?>

    </tbody>
  </table>
</div>
<?php }else{ echo $app->ui->wrapperInfo("dashboard-no-data"); } ?>