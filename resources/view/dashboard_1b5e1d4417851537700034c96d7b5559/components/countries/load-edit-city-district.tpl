
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditCityDistrict" >

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditCityDistrict"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

</form>