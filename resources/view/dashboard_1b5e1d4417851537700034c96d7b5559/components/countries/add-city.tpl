
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_80d515265452ce3d5f9c1f85c825e24c"); ?></h2>
</div>

<form class="row g-3 formAddCity" >
  <div class="col-12">
    <div>
      <label class="switch">
        <input type="checkbox" class="switch-input" name="status" value="1" checked="" >
        <span class="switch-toggle-slider">
          <span class="switch-on"></span>
          <span class="switch-off"></span>
        </span>
        <span class="switch-label" ><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
      </label>
    </div>          
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control inTranslite" />
    <label class="form-label-error" data-name="name" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_32df0c52cac96c2feb95654aab7f6e5a"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="alias" class="form-control outTranslite" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_d2af44591aef5ad60899f4904a9ce047"); ?></label>
    <input type="text" name="declension" class="form-control" />
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_cb99a3929d7dcbacd973ba81f92b5d00"); ?></label>
    <select class="form-select selectpicker" name="location_type_code" >
      <option value="0" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <?php foreach($app->component->geo->locationTypes() as $code => $type){ ?> 
        <option value="<?php echo $code; ?>" ><?php echo $type["name"]; ?></option>
      <?php } ?>         
    </select>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_cb205dd61f331f92301a027729cc6f0d"); ?></label>
    <select class="form-select selectpicker" name="region_id" data-live-search="true" >
      <option value="0" ><?php echo translate("tr_4a249e25d033d5c962a5e0a660245b63"); ?></option>
      <?php echo $app->component->geo->outRegionsOptions($data->id,$_GET["filter"]["region_id"]); ?>            
    </select>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_074cc965d5263d5d7268b8210d8df18d"); ?></label>
    <textarea name="seo_text" class="form-control" rows="4" ></textarea>
  </div>
  <div class="col-12">
  <div class="alert alert-primary d-flex align-items-center mb-0" role="alert">
    <span class="alert-icon text-primary me-2">
      <i class="ti ti-info-circle ti-xs"></i>
    </span>
    <?php echo translate("tr_445921569aa17eb74dc458095aa4ab39"); ?>
  </div>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2ed78978c74d70d32a6ef2d03ba64df4"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="latitude" class="form-control" />
    <label class="form-label-error" data-name="latitude" ></label>
  </div>
  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_fb04bb05febca0efec9dfd33d042db8a"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="longitude" class="form-control" />
    <label class="form-label-error" data-name="longitude" ></label>
  </div>
  
  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonAddCity"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
    </div>
  </div>

  <input type="hidden" name="country_id" value="<?php echo $data->id; ?>" >

</form>