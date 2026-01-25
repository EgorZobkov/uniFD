<?php
$count = $app->model->traffic_realtime->count();
?>
<div class="<?php echo $widget->size_cell; ?> mb-4 home-widget-item" data-id="<?php echo $data->id; ?>" >
  <div class="card h-100">
    <div class="card-body">

      <div class="card-title header-elements">
        <h5 class="m-0 me-2"><?php echo translateField($widget->name); ?> (<?php echo $count; ?>)</h5>
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

      <div class="mt-3">

        <?php
          $getTraffic = $app->model->traffic_realtime->sort("time_update desc limit 4")->getAll();
          if($getTraffic){

            ?>
            <ul class="p-0 mt-4">
            <?php

            foreach ($getTraffic as $key => $value) {
              ?>

                <li class="d-flex align-items-center mb-4">
                  <div class="avatar flex-shrink-0 me-3">
                    <img src="<?php echo browserDetect($value["user_agent"])->image; ?>" title="<?php echo browserDetect($value["user_agent"])->name; ?>" >
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <div class="d-flex align-items-center">
                        <h6 class="mb-0 me-1"> <a href="<?php echo $app->geo->linkToIpInfo($value["ip"]); ?>" target="_blank" ><?php echo $value["ip"]; ?></a></h6>
                      </div>
                      <small class="text-muted break-word-text"> <a href="<?php echo getHost(true).'/'.$value["uri"]; ?>" target="_blank" ><?php echo trimStr(getHost(true).'/'.$value["uri"], 60, true); ?></a> </small>
                    </div>
                  </div>
                </li>

              <?php
            }

            ?>
            </ul>
            <?php

          }else{
            echo $app->ui->wrapperInfo("dashboard-improv", ["title"=>translate("tr_14b783b4a0148bbb87dc79bd7795dc24"), "subtitle"=>translate("tr_5c5726e4958a5636dc3ff591258f5826")]); 
          }
        ?>

      <?php if($count){ ?>
      <a class="btn btn-label-primary waves-effect mt-3" href="<?php echo $app->router->getRoute("dashboard-users-traffic"); ?>" ><?php echo translate("tr_31120e649a2fe540da8cadc71826af29"); ?></a>
      <?php } ?>

      </div>
    </div>
  </div>
</div>