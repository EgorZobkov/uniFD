
<div class="mb-4">
  <h2 class="role-title font-weight-bold"><?php echo translate("tr_3fe5f0843cba1f2227f301a4b5564787"); ?></h2>
</div>

<form class="formEditServicesItemsTariff" >

<div class="row g-3" >

  <?php
    $getItems = $app->model->users_tariffs_items->getAll();
    if($getItems){

      foreach ($getItems as $key => $value) {
         ?>

          <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_65420c5c50f17b862fb6122113dd628f"); ?></label>
            <div> <strong><?php echo $value["code"]; ?></strong> </div>
          </div>

          <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></label>
            <input type="text" name="tariff_items[<?php echo $value["id"]; ?>][name]" class="form-control" value="<?php echo translateField($value["name"]); ?>" />
            <label class="form-label-error" data-name="name" ></label>
          </div>

          <div class="col-12">
            <label class="form-label" ><?php echo translate("tr_38ca0af80cd7bd241500e81ba2e6efff"); ?></label>
            <textarea name="tariff_items[<?php echo $value["id"]; ?>][text]" class="form-control" rows="4" ><?php echo translateField($value["text"]); ?></textarea>
            <label class="form-label-error" data-name="text" ></label>
          </div>         

         <?php
      }

    }
  ?>

</div>

<div class="mt-4 d-grid gap-2 col-lg-6 mx-auto">
  <button class="btn btn-primary buttonSaveEditServicesItemsTariff"><?php echo translate("tr_74ea58b6a801f0dce4e5d34dbca034dc"); ?></button>
</div>

</form>
