
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1fb693b7969ee1f3969a3de54a8cf01e"); ?></h2>
</div>

<form class="row g-3 formEditFeed" >

  <div class="col-12">
    <label class="switch">
      <input type="checkbox" name="autoupdate" class="switch-input" value="1" <?php if($data->autoupdate){ echo 'checked=""'; } ?> >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label"><?php echo translate("tr_c6ad57741debe8da5ba1a27c9d6cff25"); ?></span>
    </label>
  </div>

  <div class="col-12">
    <label class="switch">
      <input type="checkbox" name="out_filters_status" class="switch-input" value="1" <?php if($data->out_filters_status){ echo 'checked=""'; } ?> >
      <span class="switch-toggle-slider">
        <span class="switch-on"></span>
        <span class="switch-off"></span>
      </span>
      <span class="switch-label"><?php echo translate("tr_d3d765a89314c3a8ab58bfc21e898026"); ?></span>
    </label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="name" class="form-control" value="<?php echo $data->name; ?>" />
    <label class="form-label-error" data-name="name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_2d4a359881e3b8628cc10e305f999027"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="shop_title" class="form-control" value="<?php echo $data->shop_title; ?>" />
    <label class="form-label-error" data-name="shop_title" ></label>
  </div> 

  <?php if($data->feed_format == "yandex_yml"){ ?>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_7b39c2ab08fab5161a1de3ad1cc05de9"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="shop_company_name" class="form-control" value="<?php echo $data->shop_company_name; ?>" />
    <label class="form-label-error" data-name="shop_company_name" ></label>
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_9fdc3f131f7923e7bdd4ec60d465ae87"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="shop_contact_phone" class="form-control" value="<?php echo $data->shop_contact_phone; ?>" />
    <label class="form-label-error" data-name="shop_contact_phone" ></label>
  </div>

  <?php } ?>

  <div class="col-12 mt-3">
    <label class="form-label" ><?php echo translate("tr_189b9abdf7054d846c2e932086fba3a2"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="count_upload_items" class="form-control" value="<?php echo $data->count_upload_items; ?>" />
    <label class="form-label-error" data-name="count_upload_items" ></label>
  </div>

  <div class="col-12 mt-3">
    <label class="form-label" >UTM</label>
    <input type="text" name="utm_data" class="form-control" value="<?php echo $data->utm_data; ?>" />
  </div>

  <div class="col-12">
    <label class="form-label" ><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></label>
    <select name="category_id" class="form-select selectpicker" >
      <option value="" ><?php echo translate("tr_53660e081bed47bc53e7d4d247f7b15d"); ?></option>
      <?php echo $app->component->ads_categories->selectedIds($data->category_id)->getRecursionOptions(); ?>
    </select>
  </div>

  <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
    <button class="btn btn-primary buttonSaveEditFeed"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

</form>