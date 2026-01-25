
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_fa4659dc10c4dfc33fb6de329a1e5f22"); ?></h2>
</div>

<form class="row g-3 formAddFeed" >

  <div class="col-12">
    <label class="switch">
      <input type="checkbox" name="autoupdate" class="switch-input" value="1" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label"><?php echo translate("tr_c6ad57741debe8da5ba1a27c9d6cff25"); ?></span>
    </label>
  </div>

  <div class="col-12">
    <label class="switch">
      <input type="checkbox" name="out_filters_status" class="switch-input" value="1" >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label"><?php echo translate("tr_d3d765a89314c3a8ab58bfc21e898026"); ?></span>
    </label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_f8331b9a03f86f839d48d2e2b9496684"); ?><span class="form-label-importantly" >*</span></label>
    <select name="feed_format" class="form-select selectpicker" >
      <option value="" ><?php echo translate("tr_591cca300870eb571563ef4b8c8756ff"); ?></option>
      <option value="json" ><?php echo translate("tr_0ecd11c1d7a287401d148a23bbd7a2f8"); ?></option>
      <option value="yandex_yml" ><?php echo translate("tr_a1ede95e38119b4624e7dd2dc0faf68f"); ?></option>
      <option value="google_merchant" ><?php echo translate("tr_30872f3ff3d29e5b7d23537f491348de"); ?></option>
    </select>
    <label class="form-label-error" data-name="feed_format" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2d4a359881e3b8628cc10e305f999027"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="shop_title" class="form-control" value="<?php echo $app->settings->project_title; ?>" />
    <label class="form-label-error" data-name="shop_title" ></label>
  </div> 

  <div class="add-feed-format-info-container" >
    
    <div class="col-12">
      <label class="form-label" ><?php echo translate("tr_7b39c2ab08fab5161a1de3ad1cc05de9"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="shop_company_name" class="form-control" value="<?php echo $app->settings->contact_organization_name; ?>" />
      <label class="form-label-error" data-name="shop_company_name" ></label>
    </div>

    <div class="col-12 mt-3">
      <label class="form-label" ><?php echo translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"); ?><span class="form-label-importantly" >*</span></label>
      <input type="text" name="shop_contact_phone" class="form-control" value="<?php echo $app->settings->contact_phone; ?>" />
      <label class="form-label-error" data-name="shop_contact_phone" ></label>
    </div>

  </div>

  <div class="col-12 mt-3">
    <label class="form-label" ><?php echo translate("tr_189b9abdf7054d846c2e932086fba3a2"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="count_upload_items" class="form-control" value="1000" />
    <label class="form-label-error" data-name="count_upload_items" ></label>
  </div>

  <div class="col-12 mt-3">
    <label class="form-label" >UTM</label>
    <input type="text" name="utm_data" class="form-control" value="utm_source=tovaryyandex&utm_medium=cpc&utm_campaign=merchants" />
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
    <select name="category_id" class="form-select selectpicker" >
      <option value="" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></option>
      <?php echo $app->component->ads_categories->getRecursionOptions(); ?>
    </select>
  </div>

  <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
    <button class="btn btn-primary buttonAddFeed"><?php echo translate("tr_5eba283b81890978e67f4aa96dde1724"); ?></button>
  </div>

</form>