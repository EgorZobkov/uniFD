
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditCityMetro" >
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_371885a1be0c429f3bba5bcffcb96c02"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="color" class="form-control" value="<?php echo $data->color; ?>" />
    <label class="form-label-error" data-name="color" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_f029618513d41e7266f34c76e4a25525"); ?></label>
    
    <div class="country-city-metro-container" ><?php echo $app->component->geo->outSystemStationCityMetro($data->id); ?></div>
    <div><span class="btn btn-sm btn-label-primary waves-effect waves-light countrySystemAddCityMetro mt-2"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></span></div>

  </div>
  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditCityMetro"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>