
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_1167e787a81a5549bc895f4c61dcba4b"); ?></h2>
</div>

<form class="row g-3 formEditShop" >

  <div class="col-12">
    <label class="form-label label-bold" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="title" class="form-control" value="<?php echo $data->title; ?>" />
    <label class="form-label-error" data-name="title" ></label>
  </div>

  <div class="col-12">
    <label class="form-label label-bold" >Текст</label>
    <textarea rows="4" name="text" class="form-control" ><?php echo $data->text; ?></textarea>
  </div>

  <div class="col-12">
    <label class="form-label label-bold" ><?php echo translate("tr_be518714837d2c2581d28f8eed0f323b"); ?></label>
    <select class="selectpicker" name="category_id" >
      <option value="" ><?php echo translate("tr_4896dde4b49d7659c6e24c34ae55be1e"); ?></option>
      <?php echo $app->component->ads_categories->outMainCategoriesOptions($data->category_id); ?>
    </select>
    <label class="form-label-error" data-name="category_id" ></label>
  </div>

  <div class="col-12">
    <label class="form-label label-bold" ><?php echo translate("tr_89f761e974f521378e312444b39b11de"); ?><span class="form-label-importantly" >*</span></label>
    <input type="text" name="alias" class="form-control" value="<?php echo $data->alias; ?>" />
    <label class="form-label-error" data-name="alias" ></label>
  </div>

  <input type="hidden" name="id" value="<?php echo $data->id; ?>" >

  <div>
    <div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
      <button class="btn btn-primary buttonSaveEditShop"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
    </div>
  </div>

</form>