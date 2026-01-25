<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_e8f0bf758b04ddeec70cfa1833db9cda"); ?></h2>
</div>

<form class="row g-3 formAddResponder" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_6da0f0ae044012e784cdb53ab72a16f1"); ?></label>
    <select class="form-control selectpicker" name="send" >
      <option value="now" ><?php echo translate("tr_2c2777efa087962339633923333e9c3d"); ?></option>
      <option value="date" ><?php echo translate("tr_b58d88c3147c4ae34ceddd11f8105471"); ?></option>
    </select>

    <div class="chat-add-responder-send-date-container" >
      <div class="col-12 mt-3">
        <label class="form-label" ><?php echo translate("tr_b5b50c36c4c56af83956a8523a26a8c8"); ?><span class="form-label-importantly" >*</span></label>
        <input type="datetime-local" name="date" class="form-control" />
        <label class="form-label-error" data-name="date" ></label>
      </div>      
    </div>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_9d5d513baccf1366994a269b220f608f"); ?><span class="form-label-importantly" >*</span></label>

    <select class="form-control selectpicker" name="channels[]" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" multiple >
      <?php echo $app->component->chat->outChannelsOptionsDashboard(); ?>
    </select>
    <label class="form-label-error" data-name="channels" ></label>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
    <?php echo $app->ui->managerFiles(["type"=>"images", "path"=>"images"]); ?>
  </div>

  <div class="col-12">
    <label class="form-label" >Текст<span class="form-label-importantly" >*</span></label>
    <textarea class="form-control" name="text" rows="6" ></textarea>
    <label class="form-label-error" data-name="text" ></label>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddResponder"><?php echo translate("tr_8606433923deef22f8e78b1e5f245764"); ?></button>
    </div>
  </div>

</form>
