<?php
$data = $app->system->statisticSummaryByMonth();
?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements">
        <h5 class="m-0 me-2"><?php echo translate("tr_0feab850705a82d0af8a03332d8994b7"); ?> <?php echo $app->datetime->getCurrentNameMonth(); ?></h5>
        <div class="card-title-elements ms-auto">
          <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-muted"></i></span>
          <div class="dropdown">
            <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="ti ti-dots-vertical ti-sm text-muted"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" >
              <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row gy-3 mt-3 mb-3">

        <?php
          foreach ($data as $key => $value) {
              ?>

              <div class="col-md-3 col-6">
                <div class="d-flex align-items-center">
                  <div class="badge rounded-pill bg-label-primary me-3 p-2">
                    <i class="ti ti-info-square-rounded ti-sm"></i>
                  </div>
                  <div class="card-info" >
                    <h5 class="mb-0"><?php echo $value["count"]; ?> <?php if($value["count_today"]){ ?> <span class="badge bg-danger rounded-pill badge-notifications" title="<?php echo translate("tr_96269cac1c3515dd7ea0b617074d804d"); ?> +<?php if($key == "transactions_amount"){ echo $app->system->amount($value["count_today"]); }else{ echo $value["count_today"]; } ?>" >+<?php if($key == "transactions_amount"){ echo $app->system->amount($value["count_today"]); }else{ echo $value["count_today"]; } ?></span> <?php } ?></h5>
                    <small><?php echo $value["name"]; ?></small>
                    
                  </div>
                </div>
              </div>

              <?php
          }
        ?>

      </div>

    </div>
  </div>
</div>