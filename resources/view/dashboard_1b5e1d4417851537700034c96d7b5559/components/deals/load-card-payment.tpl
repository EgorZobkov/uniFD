
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_57385715bb2bc21759aa416f1e9ba1fc"); ?></h2>
</div>

<div class="btn-group-horizontal text-md-center mt-4">

  <div class="btn-group">
    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown"><?php echo translate("tr_5341fcccc531ea9b1d3e5500e0730c91"); ?></button>
    <ul class="dropdown-menu">

    	<li><span class="dropdown-item selectDealPaymentChangeStatus" data-id="<?php echo $data->id; ?>" data-status="awaiting_payment" ><?php echo translate("tr_9c9aa4d47aa4bef17500c9bc9ec97194"); ?></span></li>
      <li><span class="dropdown-item selectDealPaymentChangeStatus" data-id="<?php echo $data->id; ?>" data-status="done" ><?php echo translate("tr_188d7d98dd1b53c85b203f802e1fdf86"); ?></span></li>
      <li><span class="dropdown-item selectDealPaymentChangeStatus" data-id="<?php echo $data->id; ?>" data-status="payment_error" ><?php echo translate("tr_c6fd3c6a629b51b28c19e8495994f4ca"); ?></span></li>

    </ul>
  </div>

</div>

<div class="row g-3 mt-2" >

  <div class="deal-payment-card-container-error" >
    <form class="deal-payment-form" >

      <div class="col-12">
        <div>
          <textarea class="form-control" name="comment" placeholder="<?php echo translate("tr_5984bb35b753f52e42fd44f94cbcfa7c"); ?>" ></textarea>
          <label class="form-label-error" data-name="comment" ></label>
        </div>
      </div>
      <div class="col-12 mt-2">
        <label class="switch">
          <input type="checkbox" class="switch-input" name="notify_recipient" value="1" checked="" >
          <span class="switch-toggle-slider">
            <span class="switch-on"></span>
            <span class="switch-off"></span>
          </span>
          <span class="switch-label" ><?php echo translate("tr_1fa2b747b81a1df1585e9615917ec404"); ?></span>
        </label>          
      </div>
      <div class="text-end" ><button class="btn btn-label-primary waves-effect waves-light mt-2 buttonSaveDealPaymentError" ><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button></div>
      <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

    </form>
  </div>

  <?php if($data->comment){ ?>
  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_a0f0f2c734f6b85947d60e066ae1b1a2"); ?></label></strong>
    <div> <?php echo $data->comment; ?> </div>
  </div>
  <?php } ?>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_e3956f167dd00ecf8648f41119bd5a3e"); ?></label></strong>
    <div> <a href="<?php echo $app->router->getRoute('dashboard-user-card', [$data->whom_user->id]); ?>"><?php echo $app->user->name($data->whom_user); ?></a> </div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_c3b24050b7ddee3e38c10aaba0f14424"); ?></label></strong>
    <div><?php echo $data->payment_data->score ?: '-'; ?></div>
  </div>

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?></label></strong>
    <div><?php echo $app->system->amount($data->amount); ?></div>
  </div>

</div>
