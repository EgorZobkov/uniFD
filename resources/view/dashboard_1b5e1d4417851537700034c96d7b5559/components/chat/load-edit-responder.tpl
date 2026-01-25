<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo $data->name; ?></h2>
</div>

<form class="row g-3 formEditResponder" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_6da0f0ae044012e784cdb53ab72a16f1"); ?></label>
    <select class="form-control selectpicker" name="send" >
      <option value="now" <?php if($data->send == "now"){ echo 'selected=""'; } ?> ><?php echo translate("tr_2c2777efa087962339633923333e9c3d"); ?></option>
      <option value="date" <?php if($data->send == "date"){ echo 'selected=""'; } ?> ><?php echo translate("tr_b58d88c3147c4ae34ceddd11f8105471"); ?></option>
    </select>

    <div class="chat-add-responder-send-date-container" <?php if($data->send == "date"){ echo 'style="display: block;"'; } ?> >
      <div class="col-12 mt-3">
        <label class="form-label" ><?php echo translate("tr_b5b50c36c4c56af83956a8523a26a8c8"); ?><span class="form-label-importantly" >*</span></label>
        <input type="datetime-local" name="date" class="form-control" value="<?php echo $data->time_send; ?>" />
        <label class="form-label-error" data-name="date" ></label>
      </div>      
    </div>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_9d5d513baccf1366994a269b220f608f"); ?><span class="form-label-importantly" >*</span></label>

    <select class="form-control selectpicker" name="channels[]" title="<?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?>" multiple >
      <?php echo $app->component->chat->outChannelsOptionsDashboard(_json_decode($data->channels)); ?>
    </select>
    <label class="form-label-error" data-name="channels" ></label>

  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c318d6aece415f27decf21b272d94fa2"); ?></label>
    <?php echo $app->ui->managerFiles(["filename"=>$data->image, "type"=>"images", "path"=>"images"]); ?>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_8c45d9cf5766a98100df8108d3235247"); ?><span class="form-label-importantly" >*</span></label>
    <textarea class="form-control" name="text" rows="6" ><?php echo $data->text; ?></textarea>
    <label class="form-label-error" data-name="text" ></label>
  </div>

  <div>
    <div class="mt-2 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditResponder"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>
