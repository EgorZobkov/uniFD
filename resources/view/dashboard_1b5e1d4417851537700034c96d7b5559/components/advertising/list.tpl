<?php

$app->pagination->request($_POST);

$data = $app->model->advertising->pagination(true)->page($_POST['page'])->output($_POST['output'])->sort('id desc')->getAll();

if($data){

?>
<div class="table-responsive text-nowrap">
  <table class="table">
    <thead>
      <tr>
        <th><span><?php echo translate("tr_602680ed8916dcc039882172ef089256"); ?></span></th>
        <th><span><?php echo translate("tr_0fbab0fcd4701d6b78f2980a7a8225bc"); ?></span></th>
        <th><span><?php echo translate("tr_c95a1e2de00ee86634e177aecca00aed"); ?></span></th>
        <th><span><?php echo translate("tr_5ef6f8bba32d6df3961f0369374931f2"); ?></span></th>
        <th><span><?php echo translate("tr_0577df9ad7a2256702cd04371b2abecb"); ?></span></th>
        <th><span><?php echo translate("tr_766f70c4ed8611feba9fe5dddd620180"); ?></span></th>
        <th><span><?php echo translate("tr_7203f7a4ff564cb876e8db54c903dbfc"); ?></span></th>
        <th></th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">

      <?php

        foreach ($data as $value) {

            ?>

            <tr>
              <td>
                <?php echo $value['name']; ?>
              </td>
              <td>
                <?php echo $value['uniq_code']; ?>
              </td>
              <td>
                <?php echo $value['category_id'] ? $app->component->ads_categories->categories[$value['category_id']]["name"] : translate("tr_984bf1497dea9513aa66cf7b0e1eeb0e"); ?>
              </td>
              <td>
                <?php echo $value['geo'] ? $app->component->advertising->getGeoList(_json_decode($value['geo'])) : translate("tr_984bf1497dea9513aa66cf7b0e1eeb0e"); ?>
              </td>
              <td>
                <?php echo $value['lang_iso'] ?: translate("tr_984bf1497dea9513aa66cf7b0e1eeb0e"); ?>
              </td>
              <td>
                <?php echo $app->component->advertising->countClick($value['id']); ?>
              </td>
              <td>
                <?php
                  if($value['status']){
                    ?>
                    <span class="badge rounded-pill bg-label-success me-1"><?php echo translate("tr_87a4286b7b9bf700423b9277ab24c5f1"); ?></span>
                    <?php
                  }else{
                    ?>
                    <span class="badge rounded-pill bg-label-secondary me-1"><?php echo translate("tr_5c8419ff14d1886248d9b6771d72ff15"); ?></span>
                    <?php
                  }
                ?>
              </td>
              <td class="text-end" >

                <div class="flex-column flex-md-row align-items-center text-end">

                  <?php if($value['position'] == "page"){ ?>

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadAddSliderAdvertising" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-plus"></span>
                  </button>

                  <?php } ?>

                  <button class="btn btn-icon btn-sm btn-label-primary waves-effect waves-light loadEditAdvertising" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-pencil"></span>
                  </button>

                  <button class="btn btn-icon btn-sm btn-label-danger waves-effect waves-light deleteAdvertising" data-id="<?php echo $value['id']; ?>" >
                    <span class="ti ti-xs ti-trash"></span>
                  </button>

                </div>                

              </td>
            </tr>

            <?php
        }

      ?>

    </tbody>
  </table>
</div>
<?php
}else{
   echo $app->ui->wrapperInfo("dashboard-improv", ["filter"=>$_POST['filter'], "title"=>translate("tr_07fdc5d524bc7da218089928d3be9f4b"), "subtitle"=>translate("tr_a59ac9bd3ca22d2c6525b5ac2e7e2847")]);
}
?>