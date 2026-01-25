<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_d257199de205608325f279ed7eff0785"); ?></h2>
</div>

<form class="row g-3 formSendMessageUser" >

  <div class="col-12">
    <textarea class="form-control" name="text" rows="5" placeholder="<?php echo translate("tr_2c476e393848dc262a971afb868c4638"); ?>" ></textarea>
    <label class="form-label-error" data-name="text" ></label>
  </div>

  <div class="col-12">
    <div class="alert alert-primary d-flex align-items-center" role="alert">
      <?php echo translate("tr_203a10cc0c772eadf554874bfa8ff96c"); ?>
    </div>
  </div>

  <div class="mt-3 d-grid gap-2 col-lg-6 mx-auto">
    <button class="btn btn-primary buttonSendMessageUser"><?php echo translate("tr_6da0f0ae044012e784cdb53ab72a16f1"); ?></button>
  </div>

  <input type="hidden" name="user_id" value="<?php echo $data->id; ?>" >

</form>