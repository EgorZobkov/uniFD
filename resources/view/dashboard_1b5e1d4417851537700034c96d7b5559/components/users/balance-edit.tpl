
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_ea60ffb9b7ee1c73ceab2f551351ecb8"); ?></h2>
</div>

<form class="row g-3 formBalanceEdit" >
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_50a761a11275b70272b97775ec641e61"); ?><span class="form-label-importantly" >*</span></label>
    <select class="form-select selectpicker user-balance-change-action" name="action" >
      <option value="+" selected ><?php echo translate("tr_9edfcfc6ba7f455186cb4d6b7b5d7085"); ?></option>
      <option value="-" ><?php echo translate("tr_174f77c419886a40e05eb447611b8dac"); ?></option>
    </select>
    <label class="form-label-error" data-name="action" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_cf59ebf9edf7ebe3ece76645abb6de12"); ?><span class="form-label-importantly" >*</span></label>

    <div class="input-group">
      <input type="number" class="form-control" name="amount" >
      <span class="input-group-text"><?php echo $app->system->getDefaultCurrency()->symbol; ?></span>
    </div>

    <label class="form-label-error" data-name="amount" ></label>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_a0f0f2c734f6b85947d60e066ae1b1a2"); ?></label>
    <textarea class="form-control" name="text" ></textarea>
  </div>

  <div class="col-12">
    <div class="alert alert-primary d-flex align-items-center" role="alert">
      <?php echo translate("tr_8a5ad53727370564e4bb87997bcfb019"); ?>
    </div>
  </div>

  <input type="hidden" name="user_id" value="<?php echo $data->id; ?>" >

</form>

<div class="col-12 text-center" >
  <button class="btn btn-primary waves-effect waves-light buttonBalanceEdit" ><?php echo translate("tr_e9c3a648ce9e5dcf3c96940e682a72a2"); ?></button>
  <button  class="btn btn-label-secondary waves-effect" data-bs-dismiss="modal"><?php echo translate("tr_dd9463bd5d0c650b468fc5d6cfa1073c"); ?></button>
</div>