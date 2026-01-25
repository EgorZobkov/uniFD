<?php
$data = $app->system->statisticWaitingAction();
?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?></h5>
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

      <div class="mt-4 mb-3">

          <?php if($data){ ?>

          <ul class="p-0 m-0">

            <?php
              foreach ($data as $key => $value) {

                ?>

                <li class="mb-2 pb-1 d-flex justify-content-between align-items-center">
                  <div class="d-flex justify-content-between w-100 flex-wrap">
                    <h6 class="mb-0"><?php echo $value["name"]; ?> <span class="badge badge-center rounded-pill bg-label-danger"><?php echo $value["count"]; ?></span> </h6>
                    <div class="d-flex">
                      <a href="<?php echo $value["link"]; ?>" class="btn btn-sm btn-label-primary waves-effect waves-light"> <i class="ti ti-chevron-right"></i> </a>
                    </div>
                  </div>
                </li>

                <?php

              }
            ?>

          </ul>

          <?php }else{ echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_8b220eda06fa5222a1966e616f2f4e0c"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]); } ?>

      </div>
      
    </div>
  </div>
</div>