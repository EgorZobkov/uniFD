<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card mh-250" >
    <div class="card-body card-widget-gradient-bg">

      <div class="card-widget-gradient-layer1" >

        <div class="card-title header-elements mb-0 pb-0">
          <div class="card-title-elements ms-auto">
            <span class="widget-sortable-handle" ><i class="tf-icons ti ti-arrows-maximize ti-sm text-white"></i></span>
            <div class="dropdown">
              <button class="btn p-0 text-white" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ti ti-dots-vertical ti-sm text-white"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end text-white" >
                <span class="dropdown-item cursor-pointer home-widget-item-remove" data-id="<?php echo $data->id; ?>" ><?php echo translate("tr_1705d7cb70e0c9d8820e1b03eca70f91"); ?></span>
                <?php if($app->settings->uniid_token){ ?>
                  <span class="dropdown-item cursor-pointer actionLogoutUniId" ><?php echo translate("tr_0f05cf8ab6a3e72c0838a392e76f3733"); ?></span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <?php if(!$app->settings->uniid_token){ ?>

          <h1 class="text-white mb-0 mt-0"> <strong>Uni ID</strong> </h1>

          <p class="text-white mb-0 mt-1" ><?php echo translate("tr_8ac1170d8b49be573d2f56ceaef5810f"); ?></p>

          <button class="btn btn-label-primary waves-effect mt-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAuthUniId" ><?php echo translate("tr_63a753751e8899416d62b1d1bbb61720"); ?></button>

        <?php }else{ echo $app->settings->uniid_data["content"]; } ?>

      </div>

      <div class="card-widget-gradient-bg-image card-widget-gradient-layer2" ></div>

    </div>
  </div>

</div>