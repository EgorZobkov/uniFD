
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="formEditReview" >

<div class="row g-3" >

  <div class="col-12">
    <strong><label class="form-label" ><?php echo translate("tr_4a3f5e52678242b15f4e65f85ff3345c"); ?></label></strong>
    <textarea name="text" class="form-control" rows="6" ><?php echo $data->text; ?></textarea>
  </div>

</div>

<div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
  <button class="btn btn-primary buttonSaveEditReview"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

<input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>
