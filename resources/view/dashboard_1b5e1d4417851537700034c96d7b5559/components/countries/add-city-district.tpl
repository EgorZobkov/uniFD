
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_c7701c918566673057340b08900fec2d"); ?></h2>
</div>

<form class="row g-3 formAddCityDistrict" >
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddCityDistrict"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

  <input type="hidden" name="city_id" value="<?php echo $data->id; ?>" >

</form>